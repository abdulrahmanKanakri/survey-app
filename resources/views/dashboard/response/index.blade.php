@extends('dashboard.layouts.master')

@section('title')
    Responses
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="float-right">
            <a 
                href="{{route('dashboard.response.exportAllSurveys')}}" 
                class="btn btn-sm btn-success"
                >Export to excel
            </a>
        </div>
        <h4 class="mb-2 mb-md-0">Responses</h4>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <form action="{{route('dashboard.response.index')}}">
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
                    <th>user</th>
                    <th>survey</th>
                    <th>submitted at</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($surveyUsers as $surveyUser)
                <tr>
                    <td>{{$surveyUser->id}}</td>
                    <td>{{$surveyUser->user->name}}</td>
                    <td>{{$surveyUser->survey->title}}</td>
                    <td>{{$surveyUser->created_at}}</td>
                    <td>
                        <a href="{{route('dashboard.response.show', $surveyUser->id)}}" 
                            class="btn btn-info btn-sm"
                            >show
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">
            {{$surveyUsers->appends(request()->query())->links()}}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    setQueryValuesIntoFilters();
</script>
@endpush