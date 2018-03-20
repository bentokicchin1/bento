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
<!-- {!! Html::style('admin/bower_components/font-awesome/css/font-awesome.min.css') !!} -->
<!-- Ionicons -->
{!! Html::style('admin/bower_components/Ionicons/css/ionicons.min.css') !!}
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
<!-- fullCalendar -->
{!! Html::style('admin/bower_components/fullcalendar/dist/fullcalendar.min.css') !!}
<!-- Google Font -->
{!! Html::style('//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic') !!}
<!-- Select2 -->
{!! Html::style('admin/bower_components/select2/dist/css/select2.min.css') !!}
<!-- jQuery 3 -->
{!! Html::script('admin/bower_components/jquery/dist/jquery.min.js') !!}
<!-- jQuery UI 1.11.4 -->
{!! Html::script('admin/bower_components/jquery-ui/jquery-ui.min.js') !!}
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- Bootstrap 3.3.7 -->
{!! Html::script('admin/bower_components/bootstrap/dist/js/bootstrap.min.js') !!}
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
    @include('admin.layouts.header')
    @include('admin.layouts.sidebar')
    <div class="content-wrapper">
    @include('layouts.success')
    @include('layouts.errors')
    @yield('content')
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>

    {!! Html::script('admin/custom.js') !!}
    {!! Html::script('//use.fontawesome.com/releases/v5.0.8/js/all.js') !!}
    <!-- Morris.js charts -->
    {!! Html::script('admin/bower_components/raphael/raphael.min.js') !!}
    {!! Html::script('admin/bower_components/morris.js/morris.min.js') !!}
    <!-- jvectormap -->
    {!! Html::script('admin/bower_components/jvectormap/jquery-jvectormap.js') !!}
    <!-- Sparkline -->
    {!! Html::script('admin/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') !!}
    <!-- daterangepicker -->
    {!! Html::script('admin/bower_components/moment/min/moment.min.js') !!}
    <!-- fullCalendar -->
    {!! Html::script('admin/bower_components/fullcalendar/dist/fullcalendar.min.js') !!}
    <!-- datepicker -->
    {!! Html::script('admin/bower_components/bootstrap-daterangepicker/daterangepicker.js') !!}
    {!! Html::script('admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') !!}
    <!-- Select2 -->
    {!! Html::script('admin/bower_components/select2/dist/js/select2.full.min.js') !!}
    <!-- jQuery Knob Chart -->
    {!! Html::script('admin/bower_components/jquery-knob/dist/jquery.knob.min.js') !!}
    <!-- AdminLTE App -->
    {!! Html::script('admin/dist/js/adminlte.min.js') !!}
    </div>
    @include('admin.layouts.footer')
    </div>
</body>
</html>
