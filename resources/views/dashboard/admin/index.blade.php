@extends('dashboard.layouts.master')

@section('title')
Admins
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <a href="{{route('dashboard.admin.create')}}" class="btn btn-primary float-right">Create admin</a>
        <h4>Admins List</h4>
    </div>
    <div class="table-responsive">
        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                <tr>
                    <td class="text-center text-muted">{{$admin->id}}</td>
                    <td>{{$admin->name}}</td>
                    <td>{{$admin->email}}</td>
                    <td>{{$admin->roles->first()->name}}</td>
                    <td class="text-center">
                        <div class="btn-group">
                            <a href="{{route('dashboard.admin.edit', $admin->id)}}" class="btn btn-sm btn-success">
                                Edit
                            </a>
                            <form action="{{route('dashboard.admin.destroy', $admin->id)}}" method="POST" hidden>
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
