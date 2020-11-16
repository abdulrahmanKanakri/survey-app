@extends('dashboard.layouts.master')

@section('title')
    Edit admin
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        Edit admin
    </div>
    <div class="card-body">
        <form action="{{route('dashboard.admin.update', $admin->id)}}" method="post">
            @csrf
            @method('put')
        
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" 
                    value="{{$admin->name}}" placeholder="Enter admin name" required>
            </div>
        
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" 
                    value="{{$admin->email}}" placeholder="Enter admin email" required>
            </div>
        
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" 
                    placeholder="Enter admin password">
            </div>
        
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control">
                    <option value="" disabled hidden selected>Choose role</option>
                    @foreach ($roles as $role)
                        <option value="{{$role->name}}"
                            @if ($admin->roles->first()->name == $role->name)
                                selected
                            @endif
                            >{{$role->name}}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection
