<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Site title
================================================== -->
<title>Bento - Food with Diffrence</title>

<!-- Bootstrap CSS
================================================== -->
{!! Html::style('admin/bower_components/bootstrap/dist/css/bootstrap.min.css') !!}
<!-- Animate CSS
================================================== -->
{!! Html::style('css/animate.min.css') !!}
<!-- Font Icons CSS
================================================== -->
{!! Html::style('css/font-awesome.min.css') !!}
{!! Html::style('css/ionicons.min.css') !!}
<!-- Select2 -->
{!! Html::style('admin/bower_components/select2/dist/css/select2.min.css') !!}
<!-- Main CSS
================================================== -->
{!! Html::style('css/style.css') !!}
<!-- Google web font
================================================== -->
{!! Html::style('https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,300') !!}
<!-- jQuery 3 -->
{!! Html::script('admin/bower_components/jquery/dist/jquery.min.js') !!}
<!-- jQuery UI 1.11.4 -->
{!! Html::script('admin/bower_components/jquery-ui/jquery-ui.min.js') !!}
<!-- Bootstrap 3.3.7 -->
{!! Html::script('admin/bower_components/bootstrap/dist/js/bootstrap.min.js') !!}
<!-- Select2 -->
{!! Html::script('admin/bower_components/select2/dist/js/select2.full.min.js') !!}
</head>
<body>
    @include('layouts.header')
    @yield('content')
    @include('layouts.footer')

    <!-- Javascript
    ================================================== -->
    <!-- Select2 -->
    {!! Html::script('admin/bower_components/select2/dist/js/select2.full.min.js') !!}
    {!! Html::script('js/isotope.js') !!}
    {!! Html::script('js/imagesloaded.min.js') !!}
    {!! Html::script('js/wow.min.js') !!}
    {!! Html::script('js/custom.js') !!}
</body>
</html>
