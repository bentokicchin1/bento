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
          {!! Html::style('css/bootstrap.min.css') !!}
          <!-- Animate CSS
          ================================================== -->
          {!! Html::style('css/animate.min.css') !!}

          <!-- Font Icons CSS
          ================================================== -->
          {!! Html::style('css/font-awesome.min.css') !!}
          {!! Html::style('css/ionicons.min.css') !!}
          <!-- Main CSS
          ================================================== -->
          {!! Html::style('css/style.css') !!}

          <!-- {!! Html::style('css/pf.min.css') !!}
          {!! Html::style('css/myaccount.min.css') !!} -->

          <!-- Google web font 
          ================================================== -->
          {!! Html::style('https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,300') !!}

      </head>
      <body>
      @include('layouts.header')
      

      @yield('content')
      @include('layouts.footer')

    <!-- Javascript 
    ================================================== -->
    {!! Html::script('js/jquery.js') !!}
    {!! Html::script('js/isotope.js') !!}
    {!! Html::script('js/imagesloaded.min.js') !!}
    {!! Html::script('js/wow.min.js') !!}
    {!! Html::script('js/custom.js') !!}
</body>
</html>
