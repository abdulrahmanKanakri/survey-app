@extends('dashboard.layouts.master')

@section('title')
    Questions - Create
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Create question</h4>
        </div>
        <div class="card-body">
            <form action="{{route('question.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter question title" required>
                        </div>
                        <div class="form-group">
                            <label for="survey_id">Survey</label>
                            <select name="survey_id" id="survey_id" class="form-control">
                                <option value="" hidden disabled selected>Select survey</option>
                                @foreach ($surveys as $survey)
                                    <option value="{{$survey->id}}">{{$survey->title}}</option>
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