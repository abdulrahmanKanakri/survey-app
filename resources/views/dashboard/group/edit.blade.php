@extends('dashboard.layouts.master')

@section('title')
    groups - edit
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Edit group</h4>
        </div>
        <div class="card-body">
            <form action="{{route('dashboard.group.update', $group->id)}}" method="POST">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="name">name</label>
                    <input type="text" name="name" id="name" class="form-control" required value="{{$group->name}}">
                </div>
                <div class="form-group">
                    <label for="employees">Employees</label>
                    <select name="employees[]" id="employees" class="form-control select2" multiple required>
                        @foreach ($employees as $employee)
                            <option value="{{$employee->id}}"
                                @if ($group->employees->contains('id', $employee->id))
                                    selected
                                @endif
                            >
                                {{$employee->name}}
                            </option>
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
