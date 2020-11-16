@extends('dashboard.layouts.master')

@section('title')
    Edit user
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Edit user</h4>
    </div>
    <div class="card-body">
        <form action="{{route('dashboard.user.update', $user->id)}}" method="post">
            @csrf
            @method('put')
        
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" 
                    value="{{$user->name}}" placeholder="Enter user name" required>
            </div>
        
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" 
                    value="{{$user->email}}" placeholder="Enter user email" required>
            </div>
        
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" 
                    placeholder="Enter user password">
            </div>
        
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control">
                    <option value="" disabled hidden selected>Choose role</option>
                    @foreach ($roles as $role)
                        <option value="{{$role}}"
                            @if ($user->role == $role)
                                selected
                            @endif
                            >{{$role}}
                        </option>
                    @endforeach
                </select>
            </div>
        
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection
