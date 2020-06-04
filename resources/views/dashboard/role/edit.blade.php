@extends('layouts.master')

@section('title')
    Edit role
@endsection

@push('styles')
<style>
    .col-md-12 ul.nav-pills > li:not(:last-child) {
        margin-right: 4px;
        margin-bottom: 4px;
    }
    .col-md-12 ul.nav-pills a.nav-link {
        color: #6c757d;
        border: 1px solid #ced4da !important;
        border-radius: 4px;
        transition: all .15s;
    }
    .col-md-12 ul.nav-pills a.nav-link.active {
        color: #fff;
        background-color: #607d8b;
    }
    .col-md-12 ul.nav-pills a.nav-link:hover {
        color: #fff;
        background-color: #607d8b;
    }
</style>
@endpush

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit User Role & Permissions</h1>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card card-default">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{route('role.update', $role->id)}}" method="post">
                        @csrf
                        @method('put')

                        <div class="row">
                            <div class="col-md-6">
                                {{-- name  --}}
                                @component('components.input', [
                                    'label' => 'Role name', 
                                    'name' => 'name',
                                    'id' => 'name',
                                    'placeholder'=>'Enter role name',
                                    'value' => $role->name
                                ])
                                @endcomponent
                            </div>
                            <div class="col-md-12">

                                <h5>Permissions</h5>

                                <!-- Nav tabs -->
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#books">Books</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#news">News</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#videos">Videos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#articles">Articles</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#roles">Roles</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#users">Users</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#settingsSec">Settings</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#contactsBio">Contact</a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content py-3">

                                    <div class="tab-pane container fade" id="books">
                                        @foreach ($booksPermissions as $permission)
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" name="permissions[]" 
                                                    class="custom-control-input" 
                                                    id="permission{{$permission->id}}" 
                                                    value="{{$permission->id}}"
                                                    @if ($role->permissions->contains('id', $permission->id))
                                                        checked
                                                    @endif>
                                                <label class="custom-control-label" for="permission{{$permission->id}}">
                                                    {{$permission->name}}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="tab-pane container fade" id="news">
                                        @foreach ($newsPermissions as $permission)
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" name="permissions[]" 
                                                    class="custom-control-input" 
                                                    id="permission{{$permission->id}}" 
                                                    value="{{$permission->id}}"
                                                    @if ($role->permissions->contains('id', $permission->id))
                                                        checked
                                                    @endif>
                                                <label class="custom-control-label" for="permission{{$permission->id}}">
                                                    {{$permission->name}}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="tab-pane container fade" id="articles">
                                        <div class="row">
                                            <div class="col-md-4">
                                                @foreach ($articlesPermissions as $permission)
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" name="permissions[]" 
                                                    class="custom-control-input" 
                                                    id="permission{{$permission->id}}" 
                                                    value="{{$permission->id}}"
                                                    @if ($role->permissions->contains('id', $permission->id))
                                                        checked
                                                    @endif>
                                                        <label class="custom-control-label" for="permission{{$permission->id}}">
                                                            {{$permission->name}}
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <div class="col-md-4">
                                                @foreach ($categoriesPermissions as $permission)
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" name="permissions[]" 
                                                    class="custom-control-input" 
                                                    id="permission{{$permission->id}}" 
                                                    value="{{$permission->id}}"
                                                    @if ($role->permissions->contains('id', $permission->id))
                                                        checked
                                                    @endif>
                                                        <label class="custom-control-label" for="permission{{$permission->id}}">
                                                            {{$permission->name}}
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane container fade" id="videos">
                                        @foreach ($videosPermissions as $permission)
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" name="permissions[]" 
                                                    class="custom-control-input" 
                                                    id="permission{{$permission->id}}" 
                                                    value="{{$permission->id}}"
                                                    @if ($role->permissions->contains('id', $permission->id))
                                                        checked
                                                    @endif>
                                                <label class="custom-control-label" for="permission{{$permission->id}}">
                                                    {{$permission->name}}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="tab-pane container fade" id="roles">
                                        @foreach ($rolesPermissions as $permission)
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" name="permissions[]" 
                                                    class="custom-control-input" 
                                                    id="permission{{$permission->id}}" 
                                                    value="{{$permission->id}}"
                                                    @if ($role->permissions->contains('id', $permission->id))
                                                        checked
                                                    @endif>
                                                <label class="custom-control-label" for="permission{{$permission->id}}">
                                                    {{$permission->name}}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="tab-pane container fade" id="users">
                                        @foreach ($usersPermissions as $permission)
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" name="permissions[]" 
                                                    class="custom-control-input" 
                                                    id="permission{{$permission->id}}" 
                                                    value="{{$permission->id}}"
                                                    @if ($role->permissions->contains('id', $permission->id))
                                                        checked
                                                    @endif>
                                                <label class="custom-control-label" for="permission{{$permission->id}}">
                                                    {{$permission->name}}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="tab-pane container fade" id="settingsSec">
                                        @foreach ($settingsSecPermissions as $permission)
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" name="permissions[]" 
                                                    class="custom-control-input" 
                                                    id="permission{{$permission->id}}" 
                                                    value="{{$permission->id}}"
                                                    @if ($role->permissions->contains('id', $permission->id))
                                                        checked
                                                    @endif>
                                                <label class="custom-control-label" for="permission{{$permission->id}}">
                                                    {{$permission->name}}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="tab-pane container fade" id="contactsBio">
                                        @foreach ($contactsBioPermissions as $permission)
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" name="permissions[]" 
                                                    class="custom-control-input" 
                                                    id="permission{{$permission->id}}" 
                                                    value="{{$permission->id}}"
                                                    @if ($role->permissions->contains('id', $permission->id))
                                                        checked
                                                    @endif>
                                                <label class="custom-control-label" for="permission{{$permission->id}}">
                                                    {{$permission->name}}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                    
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    $(() => {
        $('.select2').select2({
            width: 'resolve'
        });
    });
</script>
@endpush