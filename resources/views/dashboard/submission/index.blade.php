@extends('dashboard.layouts.master')

@section('title')
    Submissions
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="float-right">
            <a 
                href="{{route('dashboard.submission.exportAllSurveys')}}" 
                class="btn btn-sm btn-success"
                >Export to excel
            </a>
        </div>
        <h4 class="mb-2 mb-md-0">submissions</h4>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <form action="{{route('dashboard.submission.index')}}">
                <div class="input-group">
                    <input type="text" name="filters[survey]"
                        class="form-control" placeholder="Type a survey title">
                    <input type="text" name="filters[username]"
                        class="form-control" placeholder="Type a username">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-bordered text-center">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>employee</th>
                    <th>survey</th>
                    <th>target</th>
                    <th>due date</th>
                    <th>submissions count</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($surveyEmployees as $surveyEmployee)
                <tr>
                    <td>{{$surveyEmployee->id}}</td>
                    <td>{{$surveyEmployee->employee->name}}</td>
                    <td>{{$surveyEmployee->survey->title}}</td>
                    <td>{{$surveyEmployee->target}}</td>
                    <td>{{$surveyEmployee->due_date}}</td>
                    <td>{{$surveyEmployee->submissions_count}}</td>
                    <td>
                        <a href="{{route('dashboard.submission.show', $surveyEmployee->id)}}" 
                            class="btn btn-info btn-sm"
                            >show
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- <div class="mt-3">
            {{$surveyEmployees->appends(request()->query())->links()}}
        </div> --}}
    </div>
</div>
@endsection

@push('scripts')
<script>
    setQueryValuesIntoFilters();
</script>
@endpush