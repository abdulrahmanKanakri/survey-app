@extends('dashboard.layouts.master')

@section('title')
    Surveys - Create
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Create survey</h4>
        </div>
        <div class="card-body">
            <form action="{{route('dashboard.survey.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" 
                                placeholder="Enter survey title" required>
                        </div>
                        <div class="form-group">
                            <label for="type">type</label>
                            <select name="type" id="type" class="form-control">
                                @foreach ($types as $type)
                                    <option value="{{$type}}">{{$type}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="publish_date">publish date</label>
                            <input 
                                type="date" 
                                name="publish_date" 
                                id="publish_date" 
                                class="form-control" 
                            />
                        </div>
                        <div class="form-group">
                            <label for="due_date">due date</label>
                            <input 
                                type="date" 
                                name="due_date" 
                                id="due_date" 
                                class="form-control" 
                            />
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="10" class="form-control" 
                                required placeholder="Enter survey description"
                            ></textarea>
                        </div>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection