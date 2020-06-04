@extends('dashboard.layouts.master')

@section('title')
    Users
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{route('user.create')}}" class="btn btn-primary float-right">Create user</a>
        <h4>Users List</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered text-center">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        @if ($user->roles->count() > 0)
                            {{$user->roles->first()->name}}
                        @endif
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{route('user.show', $user->id)}}" class="btn btn-sm btn-secondary">
                                Show
                            </a>
                            <a href="{{route('user.edit', $user->id)}}" class="btn btn-sm btn-success">
                                Edit
                            </a>
                            <form action="{{route('user.destroy', $user->id)}}" method="POST" class="d-none">
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
    </div>
</div>
@endsection