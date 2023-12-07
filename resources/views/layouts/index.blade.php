<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Pendukung Keputusan</title>

    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('assets/icon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/icon/programming.png')}}">
    <link rel="manifest" href="{{asset('/assets/icon/site.webmanifest')}}">
    <link rel="mask-icon" href="{{asset('assets/icon/safari-pinned-tab.svg')}}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">



    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Bootstrap-->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <!-- Datatables-->
    <link rel="stylesheet" href="{{asset('assets/css/datatables.min.css')}}" />
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('layouts.navbar')
        @include('layouts.sidebar')
        @yield('content')
        @include('layouts.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- JQuery-->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <!-- Bootstrap-->
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Datatables-->
    <script src="{{asset('assets/js/datatables.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('assets/dist/js/adminlte.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('[data-widget="pushmenu"]').on('click', function () {
                $('body').toggleClass('sidebar-collapse');
            });
    
            $('[data-widget="navbar-search"]').on('click', function () {
                $('.navbar-search-block').toggleClass('show');
            });
        });
    </script>
    
    @yield('script')
</body>

</html>

