@extends('user-end.layouts.master')

@section('title')
Start Survey - {{$survey->title}}
@endsection

@section('content')
<div class="container py-4" id="answering-page">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1>{{$survey->title}}</h1>
            <p class="mb-4">{{$survey->description}}</p>
            {{-- <div class="progress" style="height:25px; border-radius: 2px">
                <div class="progress-bar" style="width:40%;height:25px">40%</div>
            </div> --}}

            <form action="{{route('submitInProgressSurvey', $survey->uuid)}}" 
                id="question-form" 
                method="POST">
                @csrf
                <input type="hidden" name="question_data" value="{{$question}}">
                <input type="hidden" name="question[id]" value="{{$question->id}}">
                <!-- The Question -->
                <div class="card">
                    <div class="card-header">
                        @if ($question->required)
                            <span class="required">*</span>
                        @endif
                        <h5 class="d-inline-block">{{$question->title}}</h5>
                    </div>
                    <div class="card-body">
                        @if ($question->answers->count() > 0)
                            @foreach ($question->answers as $answer)
                                @include('inputs.input')
                            @endforeach
                        @else
                            @include('inputs.input')
                        @endif
                    </div>
                </div>
            </form>
            <form action="{{route('previousQuestion', $survey->uuid)}}" 
                method="POST" id="back-form" class="d-none">
                @csrf
            </form>
            <div class="d-flex justify-content-between">
                <button class="btn btn-secondary" id="back-btn">Back</button>
                <button class="btn btn-secondary" id="next-btn">Next</button>
            </div>
        </div>
    </div>
</div>
@endsection
