@extends('dashboard.layouts.master')

@section('title')
    Surveys - Edit
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Edit survey</h4>
        </div>
        <div class="card-body">
            <form action="{{route('dashboard.survey.update', $survey->id)}}" method="POST">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control"
                                value="{{$survey->title}}" placeholder="Enter survey title" required>
                        </div>
                        <div class="form-group">
                            <label for="type">type</label>
                            <select name="type" id="type" class="form-control">
                                @foreach ($types as $type)
                                    <option value="{{$type}}"
                                        @if ($survey->type == $type)
                                            selected
                                        @endif
                                        >{{$type}}
                                    </option>
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
                                value="{{$survey->getPublishDate('Y-m-d')}}"
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="10" class="form-control" required
                                placeholder="Enter survey description"
                            >{{$survey->description}}</textarea>
                        </div>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection