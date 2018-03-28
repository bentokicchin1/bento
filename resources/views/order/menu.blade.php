@extends('layouts.master')

@section('content')
<style>
.input-group-addon, .input-group-btn {
    vertical-align: top;
}
</style>
<!-- Header section
    ================================================== -->
<section id="header-custom">
    <div class="container bottom-line">
        <div class="row">
            <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">
                <div class="header-thumb">
                    <h1 class="wow" data-wow-delay="0s">Order Now</h1>
                    <h3 class="wow" data-wow-delay="0s">Feeling hungry, lets place the order</h3>
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
            <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 order wow fadeIn" data-wow-delay="0s">
                @if(!empty($dishes['dishData']))
                @include('layouts.success')
                @include('layouts.errors')
                <div class="order-form">

                    {{ Form::open(['route' => 'addressSelect', 'method' => 'post']) }}
                    {{ Form::hidden('orderTypeId', $dishes['orderTypeId']) }}

                    @foreach ($dishes['dishData'] as $dish)
                    @if ($dish['dishTypeName'] != 'others')
                    <div class="row">
                        <div class="col-md-6">
                          {{ Form::select($dish['dishTypeName'], $dish['dishList'], '', ['class' => 'form-control dropdown dishLists','placeholder' => 'Please select '.$dish['dishTypeName'] ])}}
                        </div>
                        <div class="col-md-3">
                          <div class="input-group">
                              <span class="input-group-btn">
                                  <button type="button" id="" class="quantity-left-minus btn btn-danger btn-number"  data-type="minus" data-field="">
                                    <span class="glyphicon glyphicon-minus"></span>
                                  </button>
                              </span>
                              {{ Form::text('qty_'.$dish['dishTypeName'],old('qty_'.$dish['dishTypeName']) , ['class' => 'form-control input-number', 'placeholder' => 'Quantity']) }}
                              <span class="input-group-btn">
                                <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field="">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
                            </span>
                          </div>
                        </div>
                        <div class="col-md-2">
                          {{ Form::hidden('basePrice_'.$dish['dishTypeName'],0, []) }}
                          {{ Form::text('price_'.$dish['dishTypeName'],0, ['class' => 'form-control','readonly'=>'true']) }}
                        </div>
                    </div>
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
                @else
                <h4 style="text-align:center;">No data found</h4>
                @endif
            </div>
        </div>
    </div>
</section>
<script>
var dishes = '<?php echo json_encode($dishes); ?>';
  $(document).ready(function(){
    var dishesData = jQuery.parseJSON(dishes);
    $(".dishLists").on('change',function(){
        var dishTypeName = $(this).attr('name');
        var selectedDishId = $(this).val();
        if(dishesData.hasOwnProperty('dishData')){
            $(dishesData['dishData']).each(function(key,dishList) {
              if(dishList['dishTypeName']==dishTypeName)
                // var priceBoxName = 'basePrice_'+dishTypeName;
                $(dishList).each(function( key,dish) {
                    if(dish['dishPrice'].hasOwnProperty(selectedDishId)){
                      $("[name='basePrice_"+dishTypeName+"']").val(Math.round(dish['dishPrice'][selectedDishId]));
                      calculateTotal();
                      return true;
                    }
                });
            });
        }
    });

    $('select').select2({
      width : '100%',
      height: '50px'
    });

    function calculateTotal(){
        var orderTotal = 0;
        var dishTotal = 0;
        $(".dishLists").each(function() {
            var dishTypeName = $(this).attr('name');
            var quantity = parseInt($('[name="qty_'+dishTypeName+'"]').val());
            var basePrice = parseInt($('[name="basePrice_'+dishTypeName+'"]').val());
            if(!isNaN(quantity) && !isNaN(basePrice)){
              dishTotal = quantity * basePrice;
            }else{
              dishTotal = 0;
            }
            $('[name="price_'+dishTypeName+'"]').val(dishTotal);
            orderTotal = parseInt(orderTotal) + parseInt(dishTotal);
        });
    }

    var quantitiy=0;
    $('.quantity-right-plus').click(function(e){
        e.preventDefault();
        var boxName = $(this).parent().siblings('input').attr('name');
        var quantity = parseInt($('[name="'+boxName+'"]').val());
        if(isNaN(quantity)){
          quantity = 1;
          $('[name="'+boxName+'"]').val(quantity);
        }else{
          $('[name="'+boxName+'"]').val(quantity + 1);
        }
        calculateTotal();
    });

    $('.quantity-left-minus').click(function(e){
        e.preventDefault();
        var boxName = $(this).parent().siblings('input').attr('name');
        var quantity = parseInt($('[name="'+boxName+'"]').val());
        if(quantity>0){
          $('[name="'+boxName+'"]').val(quantity - 1);
        }
        calculateTotal();
    });
  });
</script>

@endsection
