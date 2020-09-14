@extends('dashboard.layouts.master')

@section('title')
    Questions
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{route('dashboard.question.create')}}" class="btn btn-primary float-right">Create question</a>
        <h4>Questions</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered text-center">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>title</th>
                    <th>survey</th>
                    <th>actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($questions as $question)
                <tr>
                    <td>{{$question->id}}</td>
                    <td>{{$question->title}}</td>
                    <td>{{$question->survey->title}}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{route('dashboard.question.edit', $question->id)}}" class="btn btn-sm btn-success">
                                Edit
                            </a>
                            <form action="{{route('dashboard.question.destroy', $question->id)}}" method="POST" class="d-none">
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
            {{$questions->links()}}
        </div>
    </div>
</div>
@endsection