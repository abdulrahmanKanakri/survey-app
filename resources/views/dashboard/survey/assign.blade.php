@extends('dashboard.layouts.master')

@section('title')
    Assign Survey - {{$survey->title}}
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        Assign Survey
    </div>
    <div class="card-body">
        <form action="{{route('dashboard.survey.assign', $survey->id)}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="users">Users</label>
                <select name="users[]" id="users" class="form-control select2" multiple>
                    @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <input type="checkbox" id="select-all">
                <label for="select-all">Select all users</label>
            </div>
            <button class="btn btn-primary">Submit</button>
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