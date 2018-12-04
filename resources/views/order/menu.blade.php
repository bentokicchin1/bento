@extends('layouts.master')

@section('content')
<style>
.input-group-addon, .input-group-btn{
  vertical-align: top;
}
.input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group{
  margin-left: 0px;
}
.input-group-btn:first-child > .btn, .input-group-btn:first-child > .btn-group{
  margin-right: 0px;
}
.btn-number{
  padding: 13px 16px;
}
.input-number,.dishPriceShow{
  max-width:50px;
}
.grandTotal{
  max-width:100px;
}
@media only screen and (max-width: 600px) {
    .btn-number {
            padding: 3px 3px !important;
    }

    .table > tbody > tr > td {
        padding: 2px !important;
    }

    .input-number, .dishPriceShow {
        max-width: 30px !important;
        height: 30px !important;
    }

    .svg-inline--fa {
        font-size: 14px !important;
        font-weight: normal !important;
    }
    .checkbox span {
        font-size: 19px !important;
    }
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
                  <div style="overflow-x:auto;">
                    <table class="table">
                      <thead>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                      </thead>
                      <tbody>
                        @foreach ($dishes['dishData'] as $dish)
                        @if ($dish['dishTypeName'] != 'others')
                          <tr>
                            <td>
                              @if(array_key_exists($dish['dishTypeId'],$orderItems['orderDishes']))
                                @if(!array_key_exists($orderItems['orderDishes'][$dish['dishTypeId']]['dishId'],$dish['dishList']))
                                {{Form::text('',$orderItems['order_dish']['name'],['class' => '','readonly'=>true ])}} @endif
                                {{ Form::select($dish['dishTypeName'], $dish['dishList'],$orderItems['orderDishes'][$dish['dishTypeId']]['dishId'], ['class' => 'ordersSelect dishLists','placeholder' => 'Please select '.$dish['dishTypeName'] ])}}
                              @else
                                {{ Form::select($dish['dishTypeName'], $dish['dishList'], '', ['class' => 'ordersSelect dishLists','placeholder' => 'Please select '.$dish['dishTypeName'] ])}}
                              @endif
                            </td>
                            <td>
                              <span class="input-group-btn">
                                  <button type="button" class="quantity-left-minus btn btn-danger btn-number"  data-type="minus" data-field="">
                                    <span class="glyphicon glyphicon-minus"></span>
                                  </button>
                              </span>
                            </td>
                            <td>
                                @if(array_key_exists($dish['dishTypeId'],$orderItems['orderDishes']))
                                  {{ Form::text('qty_'.$dish['dishTypeName'],$orderItems['orderDishes'][$dish['dishTypeId']]['quantity'] , ['class' => 'input-number', 'placeholder' => 'Quantity']) }}
                                @else
                                  {{ Form::text('qty_'.$dish['dishTypeName'],old('qty_'.$dish['dishTypeName']) , ['class' => 'input-number']) }}
                                @endif
                            </td>
                            <td>
                                <span class="input-group-btn">
                                  <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field="">
                                      <span class="glyphicon glyphicon-plus"></span>
                                  </button>
                              </span>
                            </td>
                            <td>
                              <div class="input-group">
                                @if(array_key_exists($dish['dishTypeId'],$orderItems['orderDishes']))
                                  {{ Form::hidden('basePrice_'.$dish['dishTypeName'],round($orderItems['orderDishes'][$dish['dishTypeId']]['dishPrice']), []) }}
                                  <!-- <span><i class="fas fa-rupee-sign"  aria-hidden="true"></i></span> -->
                                  {{ Form::text('price_'.$dish['dishTypeName'],round($orderItems['orderDishes'][$dish['dishTypeId']]['totalPrice']), ['class' => 'dishPriceShow','readonly'=>'true']) }}
                                @else
                                  {{ Form::hidden('basePrice_'.$dish['dishTypeName'],0, []) }}
                                  <!-- <span><i class="fas fa-rupee-sign"  aria-hidden="true"></i></span> -->
                                  {{ Form::text('price_'.$dish['dishTypeName'],0, ['class' => 'dishPriceShow','readonly'=>'true']) }}
                                @endif
                                <span class="input-group-btn m-l-5"><i class="fa fa-rupee-sign" style="font-size:24px;"></i></span>
                              </div>
                           </td>
                         </tr>
                        @endif
                      @endforeach
                    </tbody>
                  </table>
                    @foreach ($dishes['dishData'] as $dish)
                      @if ($dish['dishTypeName'] == 'others')
                        <div class="checkbox">
                          @php
                              foreach($dish['dishList'] as $dishId => $dishName){
                          @endphp
                              <label>
                              {{ Form::hidden(strtolower($dishName), round($dish['dishPrice'][$dishId]),['class' => '']) }}
                                @if(array_key_exists($dish['dishTypeId'],$orderItems['orderDishes']))
                                  @if(array_key_exists($dishId,$orderItems['orderDishes'][$dish['dishTypeId']]))
                                    {{ Form::checkbox($dish['dishTypeName'].'_'.strtolower($dishName),$dishId, true,['class' => 'otherDish']) }}
                                  @else
                                    {{ Form::checkbox($dish['dishTypeName'].'_'.strtolower($dishName), $dishId, false,['class' => 'otherDish']) }}
                                  @endif
                                @else
                                  {{ Form::checkbox($dish['dishTypeName'].'_'.strtolower($dishName), $dishId, false,['class' => 'otherDish']) }}
                                @endif
                                <span class="cr">
                                  <i class="cr-icon fa fa-check"></i>
                                </span>
                                <span>{{ $dishName }} ( <i class="fas fa-rupee-sign"></i>{{ round($dish['dishPrice'][$dishId]) }} )</span>
                              </label>
                            @php
                              }
                            @endphp
                          </div>
                        @endif
                      @endforeach
                    </div>
                    {{ Form::label('grandTotal','Grand Total:', ['class' => '']) }}
                    {{ Form::text('grandTotal','', ['id'=>'grandTotal','class' => 'grandTotal m-l-10','readonly'=>'true']) }}
                    <span class="m-l-5"><i class="fa fa-rupee-sign"></i></span>
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
