<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="shortcut icon" href="/favicon.ico"  type="image/x-icon">
<script>
    var locations = '';
</script>
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
{!! Html::style('css/ionicons.min.css') !!}
{!! Html::style('admin/bower_components/fontawesome-free-5.0.8/web-fonts-with-css/css/fontawesome-all.min.css') !!}
<!-- Select2 -->
{!! Html::style('admin/bower_components/select2/dist/css/select2.min.css') !!}
<!-- Main CSS
================================================== -->
{!! Html::style('css/style.css') !!}
<!-- Google web font
================================================== -->

{!! Html::style('//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic') !!}
<!-- jQuery 3 -->
{!! Html::script('admin/bower_components/jquery/dist/jquery.min.js') !!}
<!-- jQuery UI 1.11.4 -->
{!! Html::script('admin/bower_components/jquery-ui/jquery-ui.min.js') !!}
<!-- Bootstrap 3.3.7 -->
{!! Html::script('admin/bower_components/bootstrap/dist/js/bootstrap.min.js') !!}
<!-- Select2 -->
{!! Html::script('admin/bower_components/select2/dist/js/select2.full.min.js') !!}
{!! Html::script('admin/bower_components/fontawesome-free-5.0.8/svg-with-js/js/fontawesome-all.min.js') !!}
{!! Html::script('//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js') !!}
</head>
<body>
    @include('layouts.header')
    <div class="content-section">
      @yield('content')
    </div>
    @include('layouts.footer')

    <!-- Javascript
    ================================================== -->
    {!! Html::script('js/isotope.js') !!}
    {!! Html::script('js/imagesloaded.min.js') !!}
    {!! Html::script('js/wow.min.js') !!}
    {!! Html::script('js/custom.js') !!}
</body>
</html>
