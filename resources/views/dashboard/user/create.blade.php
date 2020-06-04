@extends('layouts.master')
@section('title')
    Create user
@endsection
@section('content')
@component('components.card', ['title' => 'Create user'])
<form action="{{route('user.store')}}" method="post">
    @csrf

    {{-- name  --}}
    @component('components.input', [
        'label' => 'Name', 
        'name' => 'name',
        'id' => 'name',
        'placeholder'=>'Enter user name'
    ])
    @endcomponent

    {{-- password  --}}
    @component('components.input', [
        'label' => 'Password', 
        'type' => 'password',
        'name' => 'password',
        'id' => 'password',
        'placeholder'=>'Enter user password'
    ])
    @endcomponent

    {{-- email  --}}
    @component('components.input', [
        'label' => 'email', 
        'type' => 'email',
        'name' => 'email',
        'id' => 'email',
        'placeholder'=>'Enter user email'
    ])
    @endcomponent

    <div class="form-group">
        <label for="role">Role</label>
        <select name="role" id="role" class="form-control">
            <option value="" disabled hidden selected>Choose role</option>
            @foreach ($roles as $role)
                <option value="{{$role->name}}">{{$role->name}}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endcomponent

@endsection