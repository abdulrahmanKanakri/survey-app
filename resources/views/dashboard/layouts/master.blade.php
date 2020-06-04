<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>@yield('title')</title>

    <!-- Includes -->
    @include('dashboard.layouts.styles')
    @include('dashboard.layouts.scripts')

    <!-- Styles -->
    @stack('styles')

</head>

<body class="hold-transition sidebar-mini">

<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        </ul>

    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <img src="{{asset('assets/AdminLTE/dist/img/AdminLTELogo.png')}}" 
                alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                style="opacity: .8">
            <span class="brand-text font-weight-light">Surveys Dashboard</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p class="text-capitalize">
                            dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('user.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p class="text-capitalize">
                            users
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('role.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-shield-alt"></i>
                        <p class="text-capitalize">
                            roles
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('survey.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-poll"></i>
                        <p class="text-capitalize">
                            surveys
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('question.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p class="text-capitalize">
                            questions
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('answer.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-reply"></i>
                        <p class="text-capitalize">
                            answers
                        </p>
                    </a>
                </li>

            </ul>

        </nav>
        <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Sweet Alert Function -->
        @if (session('status'))
            <script>
                showAlert("{{session('status')['type']}}", "{{session('status')['msg']}}");
            </script>
        @endif

        <!-- Main content -->
        <div class="content pt-4">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        <!-- /.content -->
        
    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

<!-- Scripts -->
@stack('scripts')

</body>
</html>