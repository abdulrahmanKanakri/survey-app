@extends('dashboard.layouts.master')

@section('title')
    Survey - {{$survey->title}}
@endsection

@push('styles')
<style>
    p.desc {
        border: 1px solid #cecece;
        padding: 8px;
        border-radius: 4px;
        background-color: #f8f8f8;

    }
    span.question_title {
        font-size: 18px;
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{route('survey.question.create', $survey->id)}}" class="btn btn-primary float-right">
            Create new question
        </a>
        <h2>{{$survey->title}}</h2>
    </div>
    <div class="card-body">
        <div>
            <h4 class="mb-3">Description:</h4>
            <p class="desc">
                {{$survey->description}}
            </p>
        </div>
        <hr>
        <div>
            <h4 class="mb-3">Questions:</h4>
            @if ($survey->questions->count() > 0)
                @foreach ($survey->questions as $_key => $question)
                    <div class="card">
                        <div class="card-header">
                            <span class="question_title">
                                {{$question->title}}
                            </span>
                        </div>
                        <div class="card-body">
                            @foreach ($question->answers as $key => $answer)
                                @if ($answer->type == 'checkbox' || $answer->type == 'radio')
                                <div>
                                    <input type="{{$answer->type}}" id="answer_{{$_key.'_'.$key}}">
                                    <label for="answer_{{$_key.'_'.$key}}">{{$answer->body}}</label>
                                </div>
                                @endif

                                @if ($answer->type == 'text')
                                <div class="form-group">
                                    <label for="answer_{{$_key.'_'.$key}}">{{$answer->body}}</label>
                                    <input type="text" id="answer_{{$_key.'_'.$key}}" class="form-control" disabled placeholder="Free text">
                                </div>
                                @endif

                                @if ($answer->type == 'textarea')
                                <div class="form-group">
                                    <label for="answer_{{$_key.'_'.$key}}">{{$answer->body}}</label>
                                    <textarea rows="5" id="answer_{{$_key.'_'.$key}}" class="form-control" disabled placeholder="Free text"></textarea>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                <span>There's no questions yet, </span>
                <a href="{{route('survey.question.create', $survey->id)}}">
                    Create new one.
                </a>
            @endif
        </div>
    </div>
</div>
@endsection