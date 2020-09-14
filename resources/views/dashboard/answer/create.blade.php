@extends('dashboard.layouts.master')

@section('title')
    Answers - Create
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Create answer</h4>
        </div>
        <div class="card-body">
            <form action="{{route('dashboard.answer.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="question_id">Question</label>
                            <select name="question_id" id="question_id" class="form-control">
                                <option value="" hidden disabled selected>Select question</option>
                                @foreach ($questions as $question)
                                    <option value="{{$question->id}}">{{$question->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control">
                                <option value="" hidden disabled selected>Select type</option>
                                @foreach ($types as $type)
                                    <option value="{{$type}}">{{$type}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea name="body" id="body" rows="10" class="form-control" required
                                placeholder="Enter answer body"
                            ></textarea>
                        </div>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection