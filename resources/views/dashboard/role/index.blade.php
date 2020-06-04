@extends('layouts.master')
@section('title')
    Roles
@endsection
@section('content')
<section class="content-header">
    <section class="content-header">
        @include('layouts.messages')
    </section>
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Roles List</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="card">
    <div class="card-header">
        <a href="{{route('role.create')}}" class="btn btn-primary">Create role</a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="row">
                <div class="col-sm-12 col-md-6"></div>
                <div class="col-sm-12 col-md-6"></div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <table id="example2" class="table table-bordered table-hover dataTable text-center" role="grid"
                        aria-describedby="example2_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting">#</th>
                                <th>Name</th>
                                <th>Permissions</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr role="row" class="odd">
                                <td class="sorting_1">{{$role->id}}</td>
                                <td>{{$role->name}}</td>
                                <td style="text-align: left;">
                                    @foreach ($role->permissions as $permission)
                                    <span class="badge badge-dark">
                                        {{$permission->name}}
                                    </span>
                                    @endforeach
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a href="{{route('role.edit', $role->id)}}" class="dropdown-item">Edit</a>
                                            <div>
                                                <form action="{{route('role.destroy', $role->id)}}" style="margin: 0;" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" value="delete"
                                                        class="btn btn-primary dropdown-item"
                                                        >delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $('table').dataTable();
</script>
@endpush