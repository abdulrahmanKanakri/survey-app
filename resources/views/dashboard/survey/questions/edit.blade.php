@extends('dashboard.layouts.master')

@section('title')
    Questions - Edit
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
<form action="{{route('dashboard.survey.question.update', [$survey->id, $question->id])}}" 
    id="form"
    method="POST" 
    enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="card">
        <div class="card-header">
            <h4>Edit question</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label for="title">Question title</label>
                    <input type="text" name="question_title" id="title" 
                        class="form-control" value="{{$question->title}}"
                        placeholder="Enter question title" required>
                </div>
                <div class="col-md-4">
                    <label for="question-type">Question type</label>
                    <select name="question_type" id="question-type" class="form-control">
                        <option value="" selected disabled hidden>Choose Type</option>
                        @foreach ($types as $type)
                            <option value="{{$type}}" 
                                @if ($question->type == $type)
                                    selected
                                @endif
                                >{{$type}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="question_required">Required</label>
                    <select name="question_required" id="question_required" class="form-control">
                        <option value="0" {{ $question->required == 1 ?: 'selected'}}>No</option>
                        <option value="1" {{ $question->required == 0 ?: 'selected'}}>Yes</option>
                    </select>
                </div>
            </div>
            <hr />
            <div id="wrapper" class="mb-3 {{$question->answers->count() ?: 'd-none'}}">
                <div class="mb-3">
                    <label for="answer">Add new answer</label>
                    <div class="input-group">
                        <input type="text" id="answer" class="form-control" 
                            placeholder="Write answer body" />
                        <div class="input-group-append">
                            <button id="add-new-btn" class="btn btn-primary" type="button">Add</button>
                        </div>
                    </div>
                    <a href="javascript:void(0)" style="font-size: 12px" onclick="addOtherOption()">
                        <span>Add "other" option</span> 
                        <i class="fa fa-plus-circle"></i>
                    </a>
                </div>
                <div id="answers-wrapper">
                    <button 
                        type="button"
                        class="btn btn-success btn-sm float-right"
                        onclick="this.nextElementSibling.click()"
                        >Upload from excel
                    </button>
                    <input type="file" name="excel" id="excelFile" class="d-none">
                    <h4 class="text-uppercase">Answers</h4>
                    <hr>
                    <div id="answers-container">
                        @if ($question->answers->count())
                            @foreach ($question->answers as $answer)
                            <div class="d-flex">
                                <a href="javascript:void(0)" 
                                    class="remove" 
                                    onclick="removeAnswer(this, '{{ $answer->id }}')"
                                >
                                    <i class="fa fa-trash"></i>
                                </a>
                                <a href="javascript:void(0)" 
                                    class="edit mr-2" 
                                    onclick="editAnswer(this, '{{ $answer->id }}')"
                                >
                                    <i class="fa fa-edit"></i>
                                </a>
                                <label>{{$answer->body}}</label>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <button class="btn btn-primary" type="button" onclick="submitForm()">
                Submit
            </button>
        </div>
    </div>
    <div id="based">
        <a href="javascript:void(0)" 
            style="font-size: 14px" 
            onclick="previewBased(this)"
            >Based on answer in other question ?
        </a>
        <div class="card mt-3 {{ $question->dependent_question_id ?: 'd-none' }}">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <select name="based_question" id="based-questions" 
                            class="form-control" 
                            {{ $question->dependent_question_id ?: 'disabled' }}
                        >
                            <option value="" selected disabled hidden>Choose question</option>
                            @foreach ($survey->questions as $_question)
                                @if ($_question->type == 'radio')
                                <option value="{{$_question->id}}" 
                                    data-answers="{{$_question->answers}}"
                                    @if ($question->dependent_question_id == $_question->id)
                                        selected
                                    @endif
                                    >{{$_question->title}}
                                </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select 
                            name="based_answer" 
                            id="based-answers" 
                            class="form-control {{ $question->dependent_question_id ?: 'd-none' }}"
                            {{ $question->dependent_question_id ?: 'disabled' }}
                        >
                        @if ($question->dependent_question_id)
                            @foreach ($question->dependentQuestion->answers as $answer)
                                <option value="{{$answer->id}}" 
                                    @if ($question->dependent_answer_id == $answer->id)
                                        selected
                                    @endif
                                    >{{$answer->body}}
                                </option>
                            @endforeach
                        @endif
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')

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
        basedAnswers.classList.remove('d-none');
    }

    function previewBased(a) {
        let cardBased = a.nextElementSibling;
        cardBased.classList.remove('d-none');
        cardBased.querySelectorAll('select[disabled]').forEach(select => {
            select.removeAttribute('disabled');
        });
    }
</script>

<script>

let answers_container = document.getElementById('answers-container');
let answer = document.getElementById('answer');
let addNewBtn = document.getElementById('add-new-btn');

addNewBtn.onclick = () => {
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

function addOtherOption() {
    if(document.querySelector('input[value="other"]') != null) {
        showAlert('warning', 'The other option is already exist');
        return;
    }
    cerateAnswer('other');
}

function submitForm() {
    document.getElementById('form').submit();
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

// Start Answer CRUD //
function cerateAnswer(value) {
    $.ajax({
        method: 'POST',
        url: "{{route('ajax.createAnswer')}}",
        data: {
            _token: "{{ csrf_token() }}",
            body: value,
            question_id: "{{ $question->id }}"
        },
        success: (res) => {
            let col = document.createElement('div');
            col.classList.add('d-flex');
            col.innerHTML = `<a href="javascript:void(0)" class="remove" onclick="removeAnswer(this, ${res.id})">
                                <i class="fa fa-trash"></i>
                            </a>
                            <a href="javascript:void(0)" class="edit mr-2" onclick="editAnswer(this, ${res.id})">
                                <i class="fa fa-edit"></i>
                            </a>
                            <label>${res.body}</label>`;
            
            answers_container.appendChild(col);
        }
    });
}

function cerateMultipleAnswers(answers) {
    $.ajax({
        method: 'POST',
        url: "{{ route('ajax.cerateMultipleAnswers') }}",
        data: {
            _token: "{{ csrf_token() }}",
            answers: answers,
            question_id: "{{ $question->id }}"
        },
        success: (res) => {
            res.forEach(ans => {
                let col = document.createElement('div');
                col.classList.add('d-flex');
                col.innerHTML = `<a href="javascript:void(0)" class="remove" onclick="removeAnswer(this, ${ans.id})">
                                    <i class="fa fa-trash"></i>
                                </a>
                                <a href="javascript:void(0)" class="edit mr-2" onclick="editAnswer(this, ${ans.id})">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <label>${ans.body}</label>`;
                
                answers_container.appendChild(col);
            });
        }
    });
}

function editAnswer(a, id) {
    let label = a.nextElementSibling;
    label.classList.add('d-none');

    let input = `<div class="input-group input-group-sm w-50">
                    <input 
                        type="text" 
                        class="form-control" 
                        value="${label.innerHTML}"
                    />
                    <div class="input-group-append">
                        <button 
                            class="btn btn-primary" 
                            type="button" 
                            onclick="saveEditedAnswer(this, ${id})"
                            >save
                        </button>
                    </div>
                </div>`;
    a.insertAdjacentHTML('afterend', input);
}

function saveEditedAnswer(btn, id) {
    let inputGroup = btn.parentElement.parentElement;
    let value = inputGroup.firstElementChild.value;
    let label = inputGroup.nextElementSibling;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

    $.ajax({
        method: 'POST',
        url: "{{route('ajax.editAnswer', ':id')}}".replace(':id', id),
        data: {
            _token: "{{ csrf_token() }}",
            body: value,
            question_id: "{{ $question->id }}"
        },
        success: (res) => {
            console.log(res);
            inputGroup.remove();
            label.innerHTML = value;
            label.classList.remove('d-none');
        }
    });
}

const removeAnswer = (a, id) => {
    $.ajax({
        method: 'POST',
        url: "{{route('ajax.deleteAnswer', ':id')}}".replace(':id', id),
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: (res) => {
            console.log(res);
            a.parentElement.remove();
        }
    });
}
//End Answer CRUD //

// Start Excel Stuff //
let excelFile = document.getElementById('excelFile');
excelFile.addEventListener('change', handleFileSelect, false);
 
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
                cerateMultipleAnswers(answers);
                // answers.forEach(answer => {
                //     cerateAnswer(answer.value);
                // });
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
// End Excel Stuff //

</script>

@endpush
