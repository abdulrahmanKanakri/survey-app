@extends('dashboard.layouts.master')

@section('title')
    Surveys
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{route('dashboard.survey.create')}}" 
            class="btn btn-primary btn-sm float-right">
            Create survey
        </a>
        <h4>Surveys</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered text-center">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>title</th>
                    <th>type</th>
                    <th>publish date</th>
                    <th>created at</th>
                    <th>actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($surveys as $survey)
                <tr>
                    <td>{{$survey->id}}</td>
                    <td>{{$survey->title}}</td>
                    <td>
                        <span class="badge badge-{{$survey->getColor()}}">{{$survey->type}}</span>
                    </td>
                    <td>{{$survey->getPublishDate()}}</td>
                    <td>{{$survey->created_at}}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{route('dashboard.survey.show', $survey->id)}}" class="btn btn-sm btn-info">
                                Show
                            </a>
                            <a href="{{route('dashboard.survey.edit', $survey->id)}}" class="btn btn-sm btn-success">
                                Edit
                            </a>
                            <form action="{{route('dashboard.survey.destroy', $survey->id)}}" method="POST" class="d-none">
                                @csrf
                                @method('delete')
                            </form>
                            <button class="btn btn-sm btn-danger" onclick="deleteAlert(this)">Delete</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">
            {{$surveys->links()}}
        </div>
    </div>
</div>
@endsection
