@extends('dashboard.layouts.master')

@section('title')
    Survey - {{$survey->title}}
@endsection

@push('styles')
<style>
.question-type, 
.based-on {
    font-size: 14px; 
}
.required {
    color: red;
    margin-right: 2px
}
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        @if ($survey->type == 'private')
            <a href="{{route('dashboard.survey.assignPage', $survey->id)}}" 
                class="btn btn-sm btn-info float-right ml-1">
                <span class="mr-1">Assign to users</span>
                <i class="fa fa-users"></i>
            </a>
        @endif
        <button class="btn btn-sm btn-secondary float-right ml-1" 
            title="get link"
            onclick="showAlert('Share this link', '{{$survey->getLink()}}', 'info')"
        >
            <i class="fa fa-link"></i>
        </button>
        <a 
            href="{{route('dashboard.response.exportSurvey', [$survey->id])}}" 
            class="btn btn-sm btn-success float-right"
        >
            Export to excel
        </a>
        <h3>Survey: {{$survey->title}}</h3>
        <span class="badge badge-{{$survey->getColor()}}">
            {{$survey->type}}
        </span>
    </div>
    <div class="card-body">
        <div>
            <h5 class="mb-3">Description:</h5>
            <p class="desc mb-0">
                {{$survey->description}}
            </p>
        </div>
    </div>
    <div class="card-footer">
        <small>Publish date: {{$survey->getPublishDate()}}</small>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <a href="{{route('dashboard.survey.question.create', $survey->id)}}" 
            class="btn btn-primary btn-sm float-right">
            Create new question
        </a>
        <span style="font-size: 18px">Questions</span>
    </div>
    <div class="card-body">
        @if ($survey->questions->count() > 0)
            @foreach ($survey->questions as $question)
                @if ($loop->index != 0) <hr> @endif
                <div class="d-flex justify-content-between">
                    <div class="d-flex">
                        @if ($question->required == 1)
                            <span class="required">*</span>
                        @endif
                        <div class="details">
                            <div class="question-title">
                                Question #{{$loop->index + 1}}: {{$question->title}} 
                            </div>
                            <div class="question-type">Type: {{$question->getType()}}</div>
                            @if ($question->dependent_question_id)
                            <div class="based-on">
                                Based on 
                                question: {{$question->dependentQuestion->title}} 
                                and 
                                answer: {{$question->dependentAnswer->body}}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div>
                        <a href="{{route('dashboard.survey.question.edit', [$survey->id, $question->id])}}" class="edit mr-1">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form action="{{route('dashboard.survey.question.destroy', [$survey->id, $question->id])}}" 
                            method="POST" class="d-none">
                            @csrf
                            @method('delete')
                        </form>
                        <a href="javascript:void(0)" onclick="deleteAlert(this)" class="trash">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                </div>
                <div class="row mt-3">
                    @if ($question->answers->count() > 0)
                        @foreach ($question->answers as $answer)
                        <div class="col-md-6">
                            @if ($question->getType() == 'textarea')
                                <label>{{$answer->body}}</label>
                                <textarea class="form-control" rows="5"></textarea>
                            @else
                                @if ($question->getType() == 'radio' || $question->getType() == 'checkbox')
                                    <input type="{{$question->getType()}}">
                                    <label class="ml-1">{{$answer->body}}</label>
                                @else
                                    <label>{{$answer->body}}</label>
                                    <input type="{{$question->getType()}}" class="form-control">
                                @endif
                            @endif
                        </div>
                        @endforeach
                    @else
                        <div class="col-md-6">
                            @if ($question->getType() == 'textarea')
                                <textarea class="form-control"></textarea>
                            @else
                                <input type="{{$question->getType()}}" class="form-control">
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        @else
        <div style="font-size: 14px">
            There's no questions yet, 
            <a href="{{route('dashboard.survey.question.create', $survey->id)}}">
                create the first one?
            </a>
        </div>
        @endif
    </div>
</div>
@endsection