@extends('layouts.master')

@section('content')
<style>
/**
* Change three lines
*
/* line 11 */
.select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 34px;
    user-select: none;
    -webkit-user-select: none; }

/* line 131 */
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 32px; }

/* line 139 */
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 32px;
    position: absolute;
    top: 1px;
    right: 1px;
    width: 20px; }
.input-group-btn{
    vertical-align: top;
}
#order .input-number{
    height:36px;
}
</style>
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
                            <ul class="nav nav-tabs ">
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
                                        <label style="font-size: 1.5em">
                                            {{ Form::checkbox('days[]', strtolower($day), true) }}
                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            <span>{{ $day }}</span>
                                        </label>
                                    </div>
                                    @foreach ($dishesArray as $dish)
                                    @if ($dish['dishTypeName'] != 'others')
                                    <div class="row">
                                        <div class="col-md-6">
                                          {{ Form::select($dayName.'_'.$dish['dishTypeName'], $dish['dishList'], '', ['class' => 'form-control','placeholder' => 'Please select '.$dish['dishTypeName'] ])}}
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button type="button" id="" class="quantity-left-minus btn btn-danger btn-number"  data-type="minus" data-field="">
                                                      <span class="glyphicon glyphicon-minus"></span>
                                                    </button>
                                                </span>
                                                {{ Form::text($dayName.'_'.'qty_'.$dish['dishTypeName'],old('qty_'.$dish['dishTypeName']) , ['class' => 'form-control input-number']) }}
                                                <span class="input-group-btn">
                                                  <button type="button" id="{{$dayName}}."_".{{ $dish['dishTypeName'] }}" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field="">
                                                      <span class="glyphicon glyphicon-plus"></span>
                                                  </button>
                                              </span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                          {{ Form::text($dish['dishTypeName'],old($dish['dishTypeName']) , ['class' => 'form-control','disabled'=>'disabled']) }}
                                        </div>
                                      </div>

                                    @else
                                    <div class="checkbox">
                                        @foreach ($dish['dishList'] as $dishId => $dishName)
                                        <label style="font-size: 1.5em">
                                            {{ Form::checkbox($dayName.'_'.$dish['dishTypeName'].'_'.strtolower($dishName), $dishId, true) }}
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <!-- Select2 -->
    <script>
      $(document).ready(function(){
        $('select').select2({
          width : '100%'
        });
        var quantitiy=0;
        $('.quantity-right-plus').click(function(e){
          e.preventDefault();
          console.log($(this).parent().siblings().hasClass("input-number"));
          var quantity = parseInt($('#quantity').val());
          $('#quantity').val(quantity + 1);
        });
        $('.quantity-left-minus').click(function(e){
          e.preventDefault();
          var quantity = parseInt($('#quantity').val());
          if(quantity>0){
            $('#quantity').val(quantity - 1);
          }
        });
      });
    </script>
@endsection
