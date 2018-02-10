@extends('layouts.master')

@section('content')
<!-- Header section
================================================== -->
<section id="header-custom">
    <div class="container bottom-line">
      <div class="row">
  
        <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">
          <div class="header-thumb">
            <h1 class="wow fadeIn" data-wow-delay="0.3s">Subscribe for weekly</h1>
            <h3 class="wow fadeInUp" data-wow-delay="0.3s">Decide your weekly menu</h3>
          </div>
        </div>
  
      </div>
    </div>
  </section>
  
  
  <!-- Book Now section
    ================================================== -->
<section id="order">
    <div class="container">
        <div class="row">
           <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 order wow fadeIn" data-wow-delay="0.5s">
                @include('layouts.success')
                @include('layouts.errors')
                <div class="order-form">
                    {{ Form::open(['route' => 'subscriptionAddressSelect', 'method' => 'post']) }} 
                    {{ Form::hidden('orderTypeId', $dishes['orderTypeId']) }}
                    <div class="tabbable-panel">
                        <div class="tabbable-line">
                            <ul class="nav nav-tabs ">
                                <li class="active">
                                <a href="#tab_monday" data-toggle="tab">
                                    Mon </a>
                                </li>
                                <li>
                                <a href="#tab_tuesday" data-toggle="tab">
                                    Tue </a>
                                </li>
                                <li>
                                <a href="#tab_wednesday" data-toggle="tab">
                                    Wed </a>
                                </li>
                                <li>
                                <a href="#tab_thursday" data-toggle="tab">
                                    Thu </a>
                                </li>
                                <li>
                                <a href="#tab_friday" data-toggle="tab">
                                    Fri </a>
                                </li>
                                <li>
                                <a href="#tab_saturday" data-toggle="tab">
                                    Sat </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                @php
                                    $active = false
                                @endphp

                                @foreach($dishes['dishData'] as $day => $dishesArray)

                                @php
                                    $dayNmae = strtolower($day);
                                @endphp

                                @if($active == false)
                                    <div class="tab-pane active" id="tab_{{strtolower($day)}}">
                                @else
                                    <div class="tab-pane" id="tab_{{strtolower($day)}}">
                                @endif
                                    <h1>{{ $day }}</h1>
                                    @foreach ($dishesArray as $dish)
                                    @if ($dish['dishTypeName'] != 'others')
                                        {{ Form::select($dayNmae.'_'.$dish['dishTypeName'], $dish['dishList'], '', ['class' => 'form-control drpdown','placeholder' => 'Please select '.$dish['dishTypeName'] ])}}
                                        {{ Form::text($dayNmae.'_'.'qty_'.$dish['dishTypeName'],old('qty_'.$dish['dishTypeName']) , ['class' => 'form-control text', 'placeholder' => 'Quantity']) }}
                                    @else
                                        <div class="checkbox">
                                            @php
                                                foreach($dish['dishList'] as $dishId => $dishName){
                                            @endphp
                                                <label style="font-size: 1.5em">
                                                    {{ Form::checkbox($dayNmae.'_'.$dish['dishTypeName'].'_'.strtolower($dishName), $dishId, true) }}
                                                    <span class="cr">
                                                        <i class="cr-icon fa fa-check"></i>
                                                    </span>
                                                    <span>
                                                        {{ $dishName }} ( <i class="fa fa-inr"></i>{{ round($dish['dishPrice'][$dishId]) }} )
                                                    </span>
                                                </label>
                                            @php
                                                }
                                            @endphp
                                        </div>
                                    @endif
                                    @endforeach      
                                    </div>
                                    @php
                                        $active = true
                                    @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
            
                    <div class="order-submit">
                        {{ Form::submit('Place Your Order', ['class' => 'form-control submit']) }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
@endsection