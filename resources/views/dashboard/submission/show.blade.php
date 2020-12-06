@extends('dashboard.layouts.master')

@section('title')
    Submission - Show
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <a 
            href="{{route('dashboard.submission.exportSurveyByUser', [
                $surveyEmployee->survey_id, $surveyEmployee->user_id
            ])}}" 
            class="btn btn-sm btn-success float-right"
            >Export to excel
        </a>
        <h4>Submissions</h4>
    </div>
    <div class="card-body">
        Survey: {{$surveyEmployee->survey->title}}
        <hr>
        employee: {{$surveyEmployee->employee->name}} <br>
        email: {{$surveyEmployee->employee->email}} <br>
        phone number: {{$surveyEmployee->employee->phone_number}} 
        <hr>
        @foreach ($surveyEmployee->submissions as $submission)
            <h5>Submission {{$loop->index + 1}}</h5>
            <hr>
            @foreach ($submission->userAnswers as $answer)
                Question #{{$answer->question->id}} : {{$answer->question->title}} 
                <br>
                Answer: {{$answer->response}}
                @if ($answer->question->dependent_question_id != null)
                    <br>
                    This question is based on question #{{$answer->question->dependent_question_id}}
                    and its chosen answer 
                    {{$submission->userAnswers->first(function($item) use ($answer) {
                        return $item->question_id == $answer->question->dependent_question_id;
                    })->response}}
                @endif
                <hr>
            @endforeach
        @endforeach
    </div>
</div>
@endsection
