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
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="employees">employees</label>
                        <select name="employees[]" id="employees" class="form-control select2" multiple>
                            @foreach ($employees as $employee)
                                <option value="{{$employee->id}}">{{$employee->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="groups">groups</label>
                        <select name="groups[]" id="groups" class="form-control select2" multiple>
                            @foreach ($groups as $group)
                                <option value="{{$group->id}}">{{$group->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="target">target</label>
                        <input 
                            type="number" 
                            id="target" 
                            name="target" 
                            class="form-control" 
                            placeholder="Enter target e.g. 1000"
                            required
                            min="1"
                        />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="due_date">due date</label>
                        <input type="date" id="due_date" name="due_date" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sub_target">sub target</label>
                        <input 
                            type="number" 
                            id="sub_target" 
                            name="sub_target" 
                            class="form-control" 
                            placeholder="Enter sub target e.g. 1000"
                            min="1"
                        />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sub_target_type">sub target type</label>
                        <select name="sub_target_type" id="sub_target_type" class="form-control">
                            <option value="" selected disabled hidden>Choose type</option>
                            @foreach ($subTargetTypes as $type)
                                <option value="{{$type}}">{{$type}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="notes">notes</label>
                        <textarea 
                            name="notes" 
                            id="notes" 
                            rows="5" 
                            placeholder="Write some notes.."
                            class="form-control"
                        ></textarea>
                    </div>
                </div>
            </div>
            
            <button class="btn btn-primary">Submit</button>
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
