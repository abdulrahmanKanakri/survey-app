@extends('dashboard.layouts.master')

@section('title')
    Create role
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        Create Role
    </div>
    <div class="card-body">
        <form action="{{route('dashboard.role.store')}}" method="post">
            @csrf
        
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" 
                    placeholder="Enter role name" required>
            </div>
        
            <div class="form-group">
                <label for="permissions">Choose permissions</label>
                <select name="permissions[]" id="permissions" class="form-control select2" multiple>
                    @foreach ($permissions as $permission)
                    <option value="{{$permission->id}}">
                        {{$permission->name}}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <input type="checkbox" id="select-all">
                <label for="select-all">Select all permissions</label>
            </div>
        
            <input class="btn btn-primary" type="submit" value="Submit">
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(() => {
        $('.select2').select2();
        $('#select-all').on('change', ()=> {
            if($('#select-all').is(':checked')) {
                $('.select2 > option').prop("selected", "selected");
            } else {
                $('.select2').val(null);
            }
            $('.select2').trigger('change');
        });
    });
</script>
@endpush