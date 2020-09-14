@extends('dashboard.layouts.master')

@section('title')
    Roles
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{route('dashboard.role.create')}}" class="btn btn-primary float-right">Create role</a>
        <h4>Roles List</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th style="width: 160px">Name</th>
                    <th>Permissions</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                <tr>
                    <td class="text-center text-muted">#{{$role->id}}</td>
                    <td>{{$role->name}}</td>
                    <td>
                        @if ($role->permissions->count() > 0)
                            @foreach ($role->permissions as $permission)
                                <span class="badge badge-dark">
                                    {{$permission->name}}
                                </span>
                            @endforeach
                        @else
                            <span style="font-size: 14px">No permissions given yet</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="btn-group">
                            <a href="{{route('dashboard.role.edit', $role->id)}}" class="btn btn-sm btn-success">
                                Edit
                            </a>
                            <form action="{{route('dashboard.role.destroy', $role->id)}}" method="POST" class="d-none">
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
