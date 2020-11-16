@extends('dashboard.layouts.master')

@section('title')
    Response - Show
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <a 
            href="{{route('dashboard.response.exportSurveyByUser', [
                $surveyUser->survey_id, $surveyUser->user_id
            ])}}" 
            class="btn btn-sm btn-success float-right"
            >Export to excel
        </a>
        <h3>Show Responses</h3>
    </div>
    <div class="card-body">
        Survey: {{$surveyUser->survey->title}}
        <hr>
        username: {{$surveyUser->user->name}} <br>
        email: {{$surveyUser->user->email}} <br>
        phone number: {{$surveyUser->user->phone_number}} <br>
        ip address: {{$surveyUser->user->ip ?? 'Unknown'}}
        <hr>
        @foreach ($surveyUser->userAnswers as $answer)
            Question #{{$answer->question->id}} : {{$answer->question->title}} 
            <br>
            Answer: {{$answer->response}}
            @if ($answer->question->dependent_question_id != null)
                <br>
                This question is based on question #{{$answer->question->dependent_question_id}}
                and its chosen answer 
                {{$surveyUser->userAnswers->first(function($item) use ($answer) {
                    return $item->question_id == $answer->question->dependent_question_id;
                })->response}}
            @endif
            @if ($loop->index + 1 < $surveyUser->userAnswers->count())
            <hr>
            @endif
        @endforeach
    </div>
</div>
@endsection
