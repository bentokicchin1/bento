@extends('layouts.master')

@section('content')
<style>
.input-group-addon, .input-group-btn{
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
                        <div class="col-md-5">
                          {{ Form::select($dish['dishTypeName'], $dish['dishList'], '', ['class' => 'form-control ordersSelect dishLists','placeholder' => 'Please select '.$dish['dishTypeName'] ])}}
                        </div>
                        <div class="col-md-3">
                          <div class="input-group">
                              <span class="input-group-btn">
                                  <button type="button" id="" class="quantity-left-minus btn btn-danger btn-number"  data-type="minus" data-field="">
                                    <span class="glyphicon glyphicon-minus"></span>
                                  </button>
                              </span>
                              {{ Form::text('qty_'.$dish['dishTypeName'],old('qty_'.$dish['dishTypeName']) , ['class' => 'form-control input-number']) }}
                              <span class="input-group-btn">
                                <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field="">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
                            </span>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="input-group">
                              {{ Form::hidden('basePrice_'.$dish['dishTypeName'],0, []) }}
                              <!-- <span><i class="fas fa-rupee-sign"  aria-hidden="true"></i></span> -->
                              {{ Form::text('price_'.$dish['dishTypeName'],0, ['class' => 'form-control','readonly'=>'true']) }}
                          </div>
                       </div>
                    </div>
                    @else
                        <div class="checkbox">
                            @php
                                foreach($dish['dishList'] as $dishId => $dishName){
                            @endphp
                                <label>
                                    {{ Form::hidden(strtolower($dishName), round($dish['dishPrice'][$dishId]),['class' => 'form-control']) }}
                                    {{ Form::checkbox($dish['dishTypeName'].'_'.strtolower($dishName), $dishId, false,['class' => 'form-control otherDish']) }}
                                    <span class="cr">
                                        <i class="cr-icon fa fa-check"></i>
                                    </span>
                                    <span>
                                        {{ $dishName }} ( <i class="fas fa-rupee-sign"></i>{{ round($dish['dishPrice'][$dishId]) }} )
                                    </span>
                                </label>
                            @php
                                }
                            @endphp
                        </div>
                    @endif
                    @endforeach
                    <div class="form-group">
                        {{ Form::label('grandTotal','Grand Total:', ['class' => 'col-sm-3 control-label']) }}
                        <div class="input-group">
                          <!-- <span><i class="fas fa-rupee-sign"></i></span> -->
                          {{ Form::text('grandTotal','', ['id'=>'grandTotal','class' => 'form-control','readonly'=>'true']) }}
                        </div>
                    </div>
                    <div class="order-submit">
                        {{ Form::submit('Place Your Order', ['class' => 'form-control submit']) }}
                    </div>
                    {{ Form::close() }}
                </div>
                @else
                <h4 style="text-align:center;">Sorry we are closed!</h4>
                @endif
            </div>
        </div>
    </div>
</section>
<script>
var dishes = '<?php echo json_encode($dishes); ?>';

</script>

@endsection
