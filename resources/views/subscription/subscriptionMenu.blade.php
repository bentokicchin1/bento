@extends('layouts.master')

@section('content')
<!-- Header section
================================================== -->
<section id="header-custom">
    <div class="container">
      <div class="row">
        <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">
          <div class="header-thumb">
            <h1 class="wow">Subscribe for weekly</h1>
            <h3 class="wow">Decide your weekly menu</h3>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Book Now section
    ================================================== -->
<section id="order">
    <div class="container body-content">
        <div class="row">
           <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 order wow">
                @if(!empty($dishes['dishData']))
                @include('layouts.success')
                @include('layouts.errors')
                <div class="order-form">
                    {{ Form::open(['route' => 'subscriptionAddressSelect', 'method' => 'post']) }}
                    {{ Form::hidden('orderTypeId', $dishes['orderTypeId']) }}
                    <div class="tabbable-panel">
                        <div class="tabbable-line">
                            <ul class="nav nav-tabs" id="dayTabs">
                                <li class="active"><a href="#tab_monday" data-toggle="tab">Mon</a></li>
                                <li><a href="#tab_tuesday" data-toggle="tab">Tue</a></li>
                                <li><a href="#tab_wednesday" data-toggle="tab">Wed</a></li>
                                <li><a href="#tab_thursday" data-toggle="tab">Thu</a></li>
                                <li><a href="#tab_friday" data-toggle="tab">Fri</a></li>
                                <li><a href="#tab_saturday" data-toggle="tab">Sat</a></li>
                            </ul>
                            <div class="tab-content">
                              @php
                                  $active = false
                              @endphp
                              @foreach($dishes['dishData'] as $day => $dishesArray)
                                @php
                                    $dayName = strtolower($day);
                                @endphp

                                @if($active == false)
                                    <div class="tab-pane active" id="tab_{{strtolower($day)}}">
                                @else
                                    <div class="tab-pane" id="tab_{{strtolower($day)}}">
                                @endif
                                  @if(!empty($dishesArray))
                                    <div class="checkbox">
                                        <label style="font-size: 1.5em;width:100%;">
                                             {{ Form::checkbox('days[]', strtolower($day), true) }}
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            <span>Want to Opt out for {{ $day }} ?</span>
                                        </label>
                                    </div>
                                    @foreach ($dishesArray as $dish)
                                    @if ($dish['dishTypeName'] != 'others')
                                    <div class="row">
                                        <div class="col-md-5">
                                          {{ Form::select($dish['dishTypeName'].'_'.$dayName, $dish['dishList'], '', ['class' => 'form-control dropdown dishLists','placeholder' => 'Please select '.$dish['dishTypeName'] ])}}
                                        </div>
                                        <div class="col-md-3">
                                          <div class="input-group">
                                              <span class="input-group-btn">
                                                  <button type="button" class="quantity-left-minus btn btn-danger btn-number"  data-type="minus" data-field="">
                                                    <span class="glyphicon glyphicon-minus"></span>
                                                  </button>
                                              </span>
                                              {{ Form::text('qty_'.$dish['dishTypeName'].'_'.$dayName,old($dayName.'_'.'qty_'.$dish['dishTypeName']), ['class' => 'form-control input-number']) }}
                                              <span class="input-group-btn">
                                                <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field="">
                                                    <span class="glyphicon glyphicon-plus"></span>
                                                </button>
                                            </span>
                                          </div>
                                        </div>
                                        <div class="col-md-2">
                                          <div class="input-group">
                                              {{ Form::hidden('basePrice_'.$dish['dishTypeName'].'_'.$dayName,0, []) }}
                                              <span><i class="fas fa-rupee-sign"  aria-hidden="true"></i></span>
                                              {{ Form::text('price_'.$dish['dishTypeName'].'_'.$dayName,0, ['class' => 'form-control','readonly'=>'true']) }}
                                          </div>
                                       </div>
                                    </div>
                                    @else
                                    <div class="checkbox">
                                        @foreach ($dish['dishList'] as $dishId => $dishName)
                                        <label style="font-size: 1.5em">
                                            {{ Form::hidden(strtolower($dishName), round($dish['dishPrice'][$dishId]),['class' => 'form-control']) }}
                                            {{ Form::checkbox($dish['dishTypeName'].'_'.$dayName.'_'.strtolower($dishName), $dishId, false,['class'=>'form-control otherDish']) }}
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            <span>
                                                {{ $dishName }} ( <i class="fa fa-inr"></i>{{ round($dish['dishPrice'][$dishId]) }} )
                                            </span>
                                        </label>
                                        @endforeach
                                    </div>
                                    @endif
                                    @endforeach
                                  @else
                                    <center><h5>Sorry! We are closed on this day.</h5></center>
                                  @endif
                                  </div>
                                  @php
                                      $active = true
                                  @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('grandTotal','Grand Total:', ['class' => 'col-sm-3 control-label']) }}
                        <div class="input-group">
                          <span><i class="fas fa-rupee-sign"></i></span>
                          {{ Form::text('grandTotal','', ['id'=>'grandTotal','class' => 'form-control','readonly'=>'true']) }}
                        </div>
                    </div>
                    <div class="order-submit">
                        {{ Form::submit('Place Your Order', ['class' => 'form-control submit']) }}
                    </div>
                    {{ Form::close() }}
                </div>
                @else
                <h4 style="text-align:center;">No data found</h4>
                @endif
            </div>
        </div>
    </div>
</section>
<script>
var dishes = '<?php echo json_encode($dishes['dishData']); ?>';
  $(document).ready(function() {
      // alert($(".tab-content div.active").attr('id'));
  });
</script>
@endsection
