@extends('dashboard.layouts.master')

@section('title')
    Questions - Create
@endsection

@push('styles')
<style>
    a.remove {
        color: red;
        margin-right: 8px;
    }
    div#answers-wrapper {
        border: 1px solid #eee;
        padding: 8px;
        border-radius: 4px;
    }
</style>
@endpush

@section('content')

<form action="{{route('dashboard.survey.question.store', $survey->id)}}" 
    id="form"
    method="POST" 
    enctype="multipart/form-data">
    @csrf
    <div class="card mb-3">
        <div class="card-header">
            Create question
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label for="title">Question title</label>
                    <input type="text" name="question_title" id="title" 
                        class="form-control" placeholder="Enter question title" required>
                </div>
                <div class="col-md-4">
                    <label for="question-type">Question type</label>
                    <select name="question_type" id="question-type" class="form-control">
                        <option value="" selected disabled hidden>Choose Type</option>
                        @foreach ($types as $type)
                            <option value="{{$type}}">{{$type}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="question_required">Required</label>
                    <select name="question_required" id="question_required" class="form-control">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="question_has_other">has other</label>
                    <select name="question_has_other" id="question_has_other" class="form-control">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
            </div>
            <hr>
            <div id="based">
                <a href="javascript:void(0)" 
                    style="font-size: 14px" 
                    onclick="previewBased(this)"
                    >Based on answer in other question ?
                </a>
                <div class="mt-1 d-none">
                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                <label for="based-questions">based question</label>
                                <select name="based_question" id="based-questions" class="form-control" disabled>
                                    <option value="" selected disabled hidden>Choose question</option>
                                    @foreach ($survey->questions as $question)
                                        @if ($question->type == 'radio')
                                        <option value="{{$question->id}}" 
                                            data-answers="{{$question->answers}}"
                                            >{{$question->title}}
                                        </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-none">
                                <label for="based-answers">based answer</label>
                                <select name="based_answer" 
                                    id="based-answers" 
                                    class="form-control"
                                    disabled
                                ></select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="wrapper" class="card mb-3 d-none">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>Answers</div>
                <div>
                    <button 
                        type="button"
                        class="btn btn-success btn-sm float-right"
                        onclick="this.nextElementSibling.click()"
                        >Upload from excel
                    </button>
                    <input type="file" id="excelFile" class="d-none">
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="answer">Add new answer</label>
                <div class="input-group">
                    <input type="text" id="answer" class="form-control" 
                        placeholder="Write answer body" />
                    <div class="input-group-append">
                        <button id="add-new-btn" class="btn btn-primary" type="button">Add</button>
                    </div>
                </div>
            </div>
            <div id="answers-container"></div>
        </div>
    </div>
    
    <button class="btn btn-primary" type="button" onclick="submitForm()">
        Submit
    </button>
</form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    const basedQuestions = document.getElementById('based-questions');
    const basedAnswers = document.getElementById('based-answers');
    basedQuestions.onchange = () => {
        
        let selectedQuestion = basedQuestions.querySelector(`option[value='${basedQuestions.value}']`);
        
        let answers = selectedQuestion.getAttribute('data-answers');
        answers = JSON.parse(answers);

        let options = '<option value="" selected disabled hidden>Choose answer</option>';
        answers.forEach(answer => {
            options += `<option value="${answer.id}">${answer.body}</option>`;
        });
        
        basedAnswers.innerHTML = options;
        basedAnswers.parentElement.classList.remove('d-none');
    }

    function previewBased(a) {
        let cardBased = a.nextElementSibling;
        cardBased.classList.remove('d-none');
        cardBased.querySelectorAll('select[disabled]').forEach(select => {
            select.removeAttribute('disabled');
        });
        a.remove();
    }
</script>

<script>

let answers_container = document.getElementById('answers-container');
let answer = document.getElementById('answer');

new Sortable(answers_container, {
    animation: 150,
    ghostClass: 'sortable-ghost'
});

document.getElementById('add-new-btn').onclick = () => {
    cerateAnswer(answer.value);
    answer.value = "";
}

answer.onkeypress = function(e) {
    if (!e) e = window.event;
    var keyCode = e.keyCode || e.which;
    if (keyCode == '13') {
        cerateAnswer(answer.value);
        answer.value = "";
    }
}

const removeAnswer = (a) => {
    event.preventDefault();
    a.parentElement.remove();
}

function submitForm() {
    document.getElementById('form').submit();
}

function cerateAnswer(value) {
    let col = document.createElement('div');
    col.classList.add('d-flex');
    col.innerHTML = `<a href="javascript:void(0)" class="remove" onclick="removeAnswer(this)">
                        <i class="fa fa-trash"></i>
                    </a>
                    <label>${value}</label>
                    <input type="hidden" name="answers[]" value="${value}">`;
    
    answers_container.appendChild(col);
}

document.getElementById('excelFile')
    .addEventListener('change', handleFileSelect, false);
 
var ExcelToJSON = function() {

    this.parseExcel = function(file) {
        var reader = new FileReader();

        reader.onload = function(e) {
            var data = e.target.result;
            var workbook = XLSX.read(data, {
                type: 'binary'
            });
            workbook.SheetNames.forEach(function(sheetName) {
                var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                var json_object = JSON.stringify(XL_row_object);

                let answers = JSON.parse(json_object);
                answers.forEach(answer => {
                    cerateAnswer(answer.value);
                });
            })
        };

        reader.onerror = function(ex) {
            console.log(ex);
        };

        reader.readAsBinaryString(file);
    };
};

function handleFileSelect(evt) {
    var files = evt.target.files;
    var xl2json = new ExcelToJSON();
    xl2json.parseExcel(files[0]);
}

let questionType = document.getElementById('question-type');
questionType.onchange = () => {
    let wrapper = document.getElementById('wrapper');
    if(questionType.value == 'checkbox' || questionType.value == 'radio') {
        wrapper.classList.remove('d-none');
    } else {
        wrapper.classList.add('d-none');
        answers_container.innerHTML = "";
    }
}

</script>

@endpush
