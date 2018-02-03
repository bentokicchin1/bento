@extends('layouts.master')

@section('content')
<!-- Header section
    ================================================== -->
    <section id="header-custom">
      <div class="container bottom-line">
        <div class="row">

          <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">
            <div class="header-thumb">
                <h1 class="wow" data-wow-delay="0s">Order Now</h1>
                <h3 class="wow" data-wow-delay="0s">Feeling hungry, let's place the order</h3>
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
            <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 order wow fadeIn" data-wow-delay="0s">
                <div class="order-form">

                    {{ Form::open(['route' => 'processOrder', 'method' => 'post']) }} 
                    {{ Form::hidden('orderTypeId', $dishes['orderTypeId']) }}

                    @foreach ($dishes['dishData'] as $dish)
                    @if ($dish['dishTypeName'] != 'others')
                        {{ Form::select($dish['dishTypeName'], $dish['dishList'], '', ['class' => 'form-control','placeholder' => 'Please select '.$dish['dishTypeName'] ])}}
                        {{ Form::text('qty_'.$dish['dishTypeName'],old('qty_'.$dish['dishTypeName']) , ['class' => 'form-control', 'placeholder' => 'Quantity (required)']) }}
                    @else
                        <div class="checkbox">
                            @php
                                foreach($dish['dishList'] as $dishId => $dishName){
                            @endphp
                                <label style="font-size: 1.5em">
                                    {{ Form::checkbox($dish['dishTypeName'].'_'.strtolower($dishName), $dishId, true) }}
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
                    <div class="order-submit">
                        {{ Form::submit('Place Your Order', ['class' => 'form-control submit']) }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection