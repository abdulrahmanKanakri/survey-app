@extends('user-end.layouts.master')

@section('title')
Start Survey - {{$survey->title}}
@endsection
@section('content')
<div class="container py-4" id="start-page">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1>{{$survey->title}}</h1>
            <p class="mb-4">{{$survey->description}}</p>
            <form action="{{route('submitStartSurvey', $survey->uuid)}}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <span class="required">*</span>
                        <h5 class="d-inline-block">Please enter your information</h5>
                        <p class="intro">
                            This information is required to receive the coupon.
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="username">username</label>
                            <input type="text" id="username" name="user[username]" 
                                class="form-control" value="{{session('user.username')}}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone_number">phone number</label>
                            <input type="text" id="phone_number" name="user[phone_number]" 
                                class="form-control" value="{{session('user.phone_number')}}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">email</label>
                            <input type="text" id="email" name="user[email]" 
                                class="form-control" value="{{session('user.email')}}" required>
                        </div>
                        <button class="btn btn-secondary">Next</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
