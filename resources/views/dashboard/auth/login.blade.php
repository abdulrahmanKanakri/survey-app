<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Survey</title>
    
    <!-- Includes -->
    @include('dashboard.layouts.styles')
    @include('dashboard.layouts.scripts')
    <style>
        body {
            background: linear-gradient(#4b6cb7, #182848);
        }
        label {
            text-transform: capitalize;
        }
        .card-header {
            text-transform: uppercase;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-midnight-bloom">
    <div class="container">
        <div class="row justify-content-center vh-100 align-items-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Login form
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                {{session('error')}}
                            </div>
                        @endif
                        <form action="{{route('dashboard.auth.login')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="email">email</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                    placeholder="Enter email" value="{{old('email')}}" required>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">password</label>
                                <input type="password" name="password" id="password" class="form-control" 
                                    placeholder="Enter password" required>
                            </div>
                            <button class="btn btn-primary" type="submit">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>