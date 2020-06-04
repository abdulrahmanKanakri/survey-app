@extends('dashboard.layouts.master')

@section('title')
    Questions - Create
@endsection

@push('styles')
<style>
    a.remove {
        color: red;
        float: right;
    }
</style>
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Create question</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{route('survey.question.store', $survey->id)}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">Question title</label>
                            <input type="text" name="question_title" id="title" class="form-control" placeholder="Enter question title" required>
                        </div>
                        <hr>
                        <h5>Answers</h5>
                        <div class="card answers">
                            <div class="card-body"></div>
                        </div>
                        <button class="btn btn-primary">Save</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <form>
                        <h5>Add new answer</h5>
                        <div class="form-group">
                            <select id="new" class="form-control" required>
                                <option value="text">text</option>
                                <option value="textarea">textarea</option>
                                <option value="radio">radio</option>
                                <option value="checkbox">checkbox</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" id="textInput" class="form-control" placeholder="Enter answer body">
                        </div>
                        <button type="button" class="btn btn-primary" onclick="addNewAnswer(this)">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>

    const selectTypeElement = document.getElementById('new');
    const textInput = document.getElementById('textInput');

    let n = 0;
    const addNewAnswer = (btn) => {

        n++;
        let input = '';
        let value = selectTypeElement.value;

        if(value == 'textarea') {
            input = `<div class="mb-2">
                        <a href="#" class="remove" onclick="removeAnswer(this)">&times;</a>
                        <label>${textInput.value}</label>
                        <textarea rows="5" class="form-control" placeholder="Free text"></textarea>
                        <input type="hidden" name="answers[${n}][type]" value="${value}">
                        <input type="hidden" name="answers[${n}][body]" value="${textInput.value}">
                    </div>`;
        } else if(value == 'text') {
            input = `<div class="mb-2">
                        <a href="#" class="remove" onclick="removeAnswer(this)">&times;</a>
                        <label>${textInput.value}</label>
                        <input type="text" class="form-control" placeholder="Free text">
                        <input type="hidden" name="answers[${n}][type]" value="${value}">
                        <input type="hidden" name="answers[${n}][body]" value="${textInput.value}">
                    </div>`;
        } else {
            input = `<div class="mb-2">
                        <a href="#" class="remove" onclick="removeAnswer(this)">&times;</a>
                        <input type="${value}">
                        <label>${textInput.value}</label>
                        <input type="hidden" name="answers[${n}][type]" value="${value}">
                        <input type="hidden" name="answers[${n}][body]" value="${textInput.value}">
                    </div>`;
        }

        const parent = document.querySelector('.answers .card-body');
        parent.insertAdjacentHTML('beforeend', input);
        
        btn.parentElement.reset();
    }

    const removeAnswer = (a) => {
        a.parentElement.remove();
    }

</script>
@endpush