@extends('dashboard.layouts.master')

@section('title')
    Questions - Edit
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Edit question</h4>
        </div>
        <div class="card-body">
            <form action="{{route('dashboard.question.update', $question->id)}}" method="POST">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" 
                                value="{{$question->title}}"
                                placeholder="Enter question title" required>
                        </div>
                        <div class="form-group">
                            <label for="survey_id">Survey</label>
                            <select name="survey_id" id="survey_id" class="form-control">
                                <option value="" hidden disabled selected>Select survey</option>
                                @foreach ($surveys as $survey)
                                    <option value="{{$survey->id}}"
                                        @if ($survey->id == $question->survey_id)
                                            selected
                                        @endif
                                        >{{$survey->title}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection