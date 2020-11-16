<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>@yield('title')</title>

    <!-- Includes -->
    @include('user-end.layouts.styles')
    @include('user-end.layouts.scripts')

    <!-- Styles -->
    @stack('styles')

</head>

<body>

    <!-- Sweet Alert Function -->
    @if (session('status'))
        <script>
            showAlert("{{session('status')['type']}}", "{{session('status')['msg']}}");
        </script>
    @endif

    <!-- Main Content -->
    <div id="main-content">
        @yield('content')
    </div>

    <!-- Scripts -->
    @stack('scripts')
    <script src="{{asset('assets/js/main.js')}}"></script>
</body>
</html>
