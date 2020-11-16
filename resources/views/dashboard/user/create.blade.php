@extends('dashboard.layouts.master')

@section('title')
    Create user
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Create user</h4>
    </div>
    <div class="card-body">
        <form action="{{route('dashboard.user.store')}}" method="post">
            @csrf
        
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" 
                    placeholder="Enter user name" required>
            </div>
        
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" 
                    placeholder="Enter user email" required>
            </div>
        
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" 
                    placeholder="Enter user password" required>
            </div>
        
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control">
                    <option value="" disabled hidden selected>Choose role</option>
                    @foreach ($roles as $role)
                        <option value="{{$role}}">{{$role}}</option>
                    @endforeach
                </select>
            </div>
        
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection
