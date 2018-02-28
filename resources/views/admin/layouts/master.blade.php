<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Site title
================================================== -->
<title>Bento - Admin Panel</title>
<!-- Admin custom style css -->
{!! Html::style('admin/style.css') !!}
<!-- Bootstrap 3.3.7 -->
{!! Html::style('admin/bower_components/bootstrap/dist/css/bootstrap.min.css') !!}
<!-- Font Awesome -->
{!! Html::style('admin/bower_components/font-awesome/css/font-awesome.min.css') !!}
<!-- Ionicons -->
{!! Html::style('admin/bower_components/bower_components/Ionicons/css/ionicons.min.css') !!}
<!-- Theme style -->
{!! Html::style('admin/dist/css/AdminLTE.min.css') !!}
<!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
{!! Html::style('admin/dist/css/skins/skin-blue.min.css') !!}
<!-- Morris chart -->
{!! Html::style('admin/bower_components/morris.js/morris.css') !!}
<!-- jvectormap -->
{!! Html::style('admin/bower_components/jvectormap/jquery-jvectormap.css') !!}
<!-- Date Picker -->
{!! Html::style('admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') !!}
<!-- Daterange picker -->
{!! Html::style('admin/bower_components/bootstrap-daterangepicker/daterangepicker.css') !!}
<!-- bootstrap wysihtml5 - text editor -->
{!! Html::style('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') !!}
<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
    @include('admin.layouts.header')
    @include('admin.layouts.sidebar')
    <div class="content-wrapper">
    @include('layouts.success')
    @include('layouts.errors')
    @yield('content')
    </div>
    @include('admin.layouts.footer')
    </div>
    <!-- Javascript 
    ================================================== -->
    <!-- jQuery 3 -->
    {!! Html::script('admin/bower_components/jquery/dist/jquery.min.js') !!}
    <!-- jQuery UI 1.11.4 -->
    {!! Html::script('admin/bower_components/jquery-ui/jquery-ui.min.js') !!}
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    {!! Html::script('admin/bower_components/bootstrap/dist/js/bootstrap.min.js') !!}
    <!-- Morris.js charts -->
    {!! Html::script('admin/bower_components/raphael/raphael.min.js') !!}
    {!! Html::script('admin/bower_components/morris.js/morris.min.js') !!}
    <!-- jvectormap -->
    {!! Html::script('admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') !!}
    {!! Html::script('admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') !!}
    <!-- Sparkline -->
    {!! Html::script('admin/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') !!}
    <!-- daterangepicker -->
    {!! Html::script('admin/bower_components/moment/min/moment.min.js') !!}
    {!! Html::script('admin/bower_components/bootstrap-daterangepicker/daterangepicker.js') !!}
    <!-- datepicker -->
    {!! Html::script('admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') !!}
    <!-- jQuery Knob Chart -->
    {!! Html::script('bower_components/jquery-knob/dist/jquery.knob.min.js') !!}
    <!-- Bootstrap WYSIHTML5 -->
    {!! Html::script('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') !!}
    <!-- AdminLTE App -->
    {!! Html::script('admin/dist/js/adminlte.min.js') !!}

</body>
</html>
