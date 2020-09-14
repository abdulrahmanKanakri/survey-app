@extends('dashboard.layouts.master')

@section('title')
    Answers
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{route('dashboard.answer.create')}}" class="btn btn-primary float-right">Create answer</a>
        <h4>Answers</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered text-center">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>body</th>
                    <th>type</th>
                    <th>question</th>
                    <th>actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($answers as $answer)
                <tr>
                    <td>{{$answer->id}}</td>
                    <td>{{$answer->body}}</td>
                    <td>{{$answer->type}}</td>
                    <td>{{$answer->question->title}}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{route('dashboard.answer.edit', $answer->id)}}" class="btn btn-sm btn-success">
                                Edit
                            </a>
                            <form action="{{route('dashboard.answer.destroy', $answer->id)}}" method="POST" class="d-none">
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
            {{$answers->links()}}
        </div>
    </div>
</div>
@endsection