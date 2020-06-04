@extends('layouts.master')
@section('title')
    Edit user
@endsection
@section('content')
@component('components.card', ['title' => 'Edit user'])
<form action="{{route('user.update', $user->id)}}" method="post">
    @csrf
    @method('put')

    {{-- name  --}}
    @component('components.input', [
        'label' => 'Name', 
        'name' => 'name',
        'id' => 'name',
        'value' => $user->name,
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
        'value' => $user->email,
        'placeholder'=>'Enter user email'
    ])
    @endcomponent

    <div class="form-group">
        <label for="role">Role</label>
        <select name="role" id="role" class="form-control">
            <option value="" disabled hidden selected>Choose role</option>
            @foreach ($roles as $role)
                <option value="{{$role->name}}"
                    @if ($user->roles->count() > 0 && $user->roles->first()->name == $role->name)
                        selected
                    @endif
                    >{{$role->name}}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endcomponent

@endsection