@extends('layouts.master')
@section('content')
<!-- Header section
================================================== -->
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
@media only screen and (max-width: 600px) {
    .tab-content .btn-number {
            padding: 3px 3px !important;
    }

    .tab-content .table > tbody > tr > td {
        padding: 2px !important;
    }

    .tab-content .input-number, .tab-content .dishPriceShow {
        max-width: 30px !important;
        height: 30px !important;
    }

    .tab-content .svg-inline--fa {
        font-size: 14px !important;
        font-weight: normal !important;
    }
    .tab-content .checkbox span {
        font-size: 19px !important;
    }
    .nav>li>a {
      padding: 8px 3px  !important;
    }
}
</style>
<section id="header-custom">
    <div class="container">
      <div class="row">
        <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">
          <div class="header-thumb">
            <h1 class="wow">Decide your weekly menu</h1>
            <h3 class="wow">We'll place your order everyday accordingly.</h3>
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
                    {{ Form::open(['route' => 'subscriptionAddressSelect', 'method' => 'post','id'=>'subscriptionForm']) }}
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
                                           <span>Want tiffin on {{ $day }} ?</span>
                                        <!-- </label> -->
                                    </div>
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
                                    @foreach ($dishesArray as $dish)
                                    @php
                                      $selectedDish = array();
                                      if(array_key_exists(strtolower($day),$subscribedDishes)){
                                        if(array_key_exists($dish['dishTypeName'],$subscribedDishes[strtolower($day)]['items'])){
                                            $selectedDish = $subscribedDishes[strtolower($day)]['items'][$dish['dishTypeName']];
                                        }
                                      }
                                    @endphp
                                    <tr>
                                    @if ($dish['dishTypeName'] != 'others')
                                        <td>
                                          @if(!empty($selectedDish))
                                              {{ Form::select($dish['dishTypeName'].'_'.$dayName, $dish['dishList'], $selectedDish['dish_id'], ['class' => 'ordersSelect dishLists','placeholder' => 'Please select '.$dish['dishTypeName'] ])}}
                                          @else
                                            {{ Form::select($dish['dishTypeName'].'_'.$dayName, $dish['dishList'], '', ['class' => 'ordersSelect dishLists','placeholder' => 'Please select '.$dish['dishTypeName'] ])}}
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
                                            @if(!empty($selectedDish))
                                              @if(array_key_exists($selectedDish['dish_id'],$dish['dishList']))
                                                  {{ Form::text('qty_'.$dish['dishTypeName'].'_'.$dayName,$selectedDish['qty'], ['class' => 'input-number']) }}
                                              @else
                                                  {{ Form::text('qty_'.$dish['dishTypeName'].'_'.$dayName,old($dayName.'_'.'qty_'.$dish['dishTypeName']), ['class' => 'input-number']) }}
                                              @endif
                                            @else
                                                {{ Form::text('qty_'.$dish['dishTypeName'].'_'.$dayName,old($dayName.'_'.'qty_'.$dish['dishTypeName']), ['class' => 'input-number']) }}
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
                                            @if(!empty($selectedDish))
                                              @if(array_key_exists($selectedDish['dish_id'],$dish['dishList']))
                                                  {{ Form::hidden('basePrice_'.$dish['dishTypeName'].'_'.$dayName,$selectedDish['base_price'], []) }}
                                              @else
                                                {{ Form::hidden('basePrice_'.$dish['dishTypeName'].'_'.$dayName,0, []) }}
                                              @endif
                                            @else
                                              {{ Form::hidden('basePrice_'.$dish['dishTypeName'].'_'.$dayName,0, []) }}
                                            @endif
                                            <!-- <span><i class="fas fa-rupee-sign"  aria-hidden="true"></i></span> -->
                                            @if(!empty($selectedDish))
                                                @if(array_key_exists($selectedDish['dish_id'],$dish['dishList']))
                                                  {{ Form::text('price_'.$dish['dishTypeName'].'_'.$dayName,$selectedDish['total_price'], ['class' => 'dishPriceShow','readonly'=>'true']) }}
                                                @else
                                                  {{ Form::text('price_'.$dish['dishTypeName'].'_'.$dayName,0, ['class' => 'dishPriceShow','readonly'=>'true']) }}
                                                @endif
                                            @else
                                                {{ Form::text('price_'.$dish['dishTypeName'].'_'.$dayName,0, ['class' => 'dishPriceShow','readonly'=>'true']) }}
                                            @endif
                                            <span class="input-group-btn m-l-5"><i class="fa fa-rupee-sign" style="font-size:24px;"></i></span>
                                          </div>
                                          </td>
                                      @endif
                                    </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                                @foreach ($dishesArray as $dish)
                                  @php
                                    $selectedDish = array();
                                    if(array_key_exists(strtolower($day),$subscribedDishes)){
                                      if(array_key_exists($dish['dishTypeName'],$subscribedDishes[strtolower($day)]['items'])){
                                          $selectedDish = $subscribedDishes[strtolower($day)]['items'][$dish['dishTypeName']];
                                      }
                                    }
                                  @endphp
                                  @if ($dish['dishTypeName'] == 'others')
                                    <div class="checkbox">
                                        @php
                                          $selectedOtherDish = array();
                                          if(array_key_exists(strtolower($day),$subscribedDishes)){
                                            if(array_key_exists('others',$subscribedDishes[strtolower($day)]['items'])){
                                                $selectedDish = $subscribedDishes[strtolower($day)]['items']['others'];
                                                $selectedOtherDish = array_column($subscribedDishes[strtolower($day)]['items'][$dish['dishTypeName']],'dish_id');
                                            }
                                          }
                                        @endphp
                                        @foreach ($dish['dishList'] as $dishId => $dishName)
                                        <label>
                                              {{ Form::hidden(strtolower($dishName), round($dish['dishPrice'][$dishId]),['class' => 'form-control']) }}
                                              @if(in_array($dishId,$selectedOtherDish))
                                                {{ Form::checkbox($dish['dishTypeName'].'_'.$dayName.'_'.strtolower($dishName), $dishId, true,['id'=>$dish['dishTypeName'].'_'.$dayName.'_'.strtolower($dishName),'class'=>'form-control otherDish']) }}
                                              @else
                                                {{ Form::checkbox($dish['dishTypeName'].'_'.$dayName.'_'.strtolower($dishName), $dishId, false,['id'=>$dish['dishTypeName'].'_'.$dayName.'_'.strtolower($dishName),'class'=>'form-control otherDish']) }}
                                              @endif
                                            <span class="cr">
                                              <i class="cr-icon fa fa-check"></i>
                                            </span>
                                            <span>
                                                {{ $dishName }} ( <i class="fas fa-rupee-sign"></i>{{ round($dish['dishPrice'][$dishId]) }} )
                                            </span>
                                        </label>
                                        @endforeach
                                    </div>
                                  @endif
                                @endforeach
                              </div>
                                  {{ Form::label('grandTotal','Grand Total:', ['class' => '']) }}
                                  {{ Form::text('grandTotal_'.$dayName,'',['id'=>'grandTotal_'.$dayName,'class' => 'grandTotal m-l-10','readonly'=>'true']) }}
                                  <span class="m-l-5"><i class="fa fa-rupee-sign"></i></span>
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
                    {{ Form::submit('Place Your Order', ['id'=>'subscribe','class' => 'form-control submit']) }}
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
</script>
@endsection
