@extends('dashboard.layouts.master')

@section('title')
    groups - create
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Create group</h4>
    </div>
    <div class="card-body">
        <form action="{{route('dashboard.group.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="employees">Employees</label>
                <select name="employees[]" id="employees" class="form-control select2" multiple required>
                    @foreach ($employees as $employee)
                        <option value="{{$employee->id}}">{{$employee->name}}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        $(".select2").select2();
    });
</script>
@endpush
