@extends('dashboard.layouts.master')

@section('title')
    Groups
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{route('dashboard.group.create')}}" class="btn btn-primary float-right">Create group</a>
        <h4>Groups</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered text-center">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>name</th>
                    <th>employees</th>
                    <th>actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groups as $group)
                <tr>
                    <td>{{$group->id}}</td>
                    <td>{{$group->name}}</td>
                    @php
                        $title = '';
                        foreach ($group->employees as $key => $employee) {
                            $title .= $employee->name . '<br>';
                        }
                    @endphp
                    <td>
                        <a href="#" data-toggle="tooltip" data-html="true" title="{{$title}}">
                            {{$group->employees->count()}}
                        </a>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{route('dashboard.group.edit', $group->id)}}" class="btn btn-sm btn-success">
                                Edit
                            </a>
                            <form action="{{route('dashboard.group.destroy', $group->id)}}" method="POST" class="d-none">
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
{{-- {{$groups->links()}} --}}
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush
