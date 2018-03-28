@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Order
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin-dashboard')}}"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="{{route('admin-order-list')}}">Order</a></li>
        <li><a href="#" class="active">Add Order</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <!-- <div class="callout callout-danger">
        <h4>Error!</h4>
    </div> -->
    <section class="content">
      <div class="row">
        <div class="col-md-offset-1 col-md-10 col-sm-12">
          <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Add Order </h3>
                <a href="{{ url()->previous() }}" class="btn btn-info" style="float:right">Back</a>
            </div>
            <!-- /.box-header -->
            {{ Form::open(['route' => 'admin-order-add','id'=>'adminOrderAdd', 'method' => 'post' ,'class'=>'form-horizontal']) }}
            @if(!empty($ordersData))
            {{ Form::model($ordersData, ['route' => ['admin-order-add', $ordersData['id']]]) }}
            {{ Form::hidden('id',  $ordersData['id']) }}
            @endif
            <div class="box-body">
              <div class="form-group">
                  <label for="user" class="col-sm-3 control-label" style="padding-top:7px">User</label>
                  <div class="col-sm-6">
                    @if(!empty($ordersData))
                      {{ Form::text('',$ordersData['users']['name'],array('class' => 'form-control','readonly'=>true)) }}
                      {{ Form::hidden('user', $ordersData['users']['id']) }}
                    @else
                      {{ Form::select('user',$userData,null,['id'=>'user','required'=>true,'class'=>'form-control dropdown','placeholder'=>'User (required)']) }}
                    @endif
                  </div>
              </div>
              <div class="form-group">
                  <label for="menuDate" class="col-sm-3 control-label" style="padding-top:7px">Select Day :</label>
                  <div class="col-sm-6">
                    @if(!empty($ordersData))
                        {{ Form::text('orderDate',date('l,d F,Y',strtotime($ordersData['order_date'])),array('class' => 'form-control','readonly'=>true)) }}
                    @else
                      {{ Form::text('orderDate',null,['id'=>'orderDate','required'=>true,'class'=>'form-control','placeholder'=>'Date (required)']) }}
                    @endif
                  </div>
              </div>
              <div class="form-group">
                  <label for="order_type_id" class="col-sm-3 control-label" style="padding-top:7px">Order Type</label>
                  <div class="col-sm-6">
                    @if(!empty($ordersData))
                      {{ Form::text('',$ordersData['order_type']['name'],array('class' => 'form-control','readonly'=>true)) }}
                      {{ Form::hidden('orderTypeId',$ordersData['order_type']['id']) }}
                    @else
                      {{ Form::select('orderTypeId',$orderTypeData,null,['id'=>'orderTypeId','required'=>true,'class'=>'form-control dropdown','placeholder'=>'Order Type (required)']) }}
                    @endif
                  </div>
              </div>
              <div id="dishDetails">
                  @if(!empty($dishData))
                  <label class="col-sm-3 control-label" style="padding-top:7px">Order Details</label>
                    <div class="row  col-sm-6">
                      @foreach ($dishData as $dish)
                        @if ($dish['dishTypeName'] != 'others')
                          <div class="form-group">
                            <div class="col-sm-6">
                              @if(array_key_exists($dish['dishTypeId'],$orderItems['orderDishes']))
                                @if(!array_key_exists($orderItems['orderDishes'][$dish['dishTypeId']]['dishId'],$dish['dishList'])) {{Form::text('',$orderItem['order_dish']['name'],['class' => 'form-control','readonly'=>true ])}} @endif
                                {{ Form::select($dish['dishTypeName'], $dish['dishList'],$orderItems['orderDishes'][$dish['dishTypeId']]['dishId'], ['class' => 'form-control dropdown','placeholder' => 'Please select '.$dish['dishTypeName'] ])}}
                              @else
                                {{ Form::select($dish['dishTypeName'], $dish['dishList'], null, ['class' => 'form-control dropdown','placeholder' => 'Please select '.$dish['dishTypeName'] ])}}
                              @endif
                            </div>
                            <div class="col-sm-3">
                              @if(array_key_exists($dish['dishTypeId'],$orderItems['orderDishes']))
                                {{ Form::text('qty_'.$dish['dishTypeName'],$orderItems['orderDishes'][$dish['dishTypeId']]['quantity'] , ['class' => 'form-control text', 'placeholder' => 'Quantity']) }}
                              @else
                                {{ Form::text('qty_'.$dish['dishTypeName'], null , ['class' => 'form-control text', 'placeholder' => 'Quantity']) }}
                              @endif
                            </div>
                         </div>
                      @else
                        @foreach($dish['dishList'] as $dishId => $dishName)
                          <div class="checkbox">
                            <label>
                              @if(array_key_exists(config('constants.DISH_TYPE_OTHER'),$orderItems['orderTypeIds']))
                                {{ Form::checkbox($dish['dishTypeName'].'_'.strtolower($dishName),$orderItems['orderDishes'][config('constants.DISH_TYPE_OTHER')]['dishId'], true) }}
                                <span>{{ $orderItems['orderDishes'][config('constants.DISH_TYPE_OTHER')]['dishName'] }} ( <i class="fas fa-rupee-sign"></i>{{ round($orderItems['orderDishes'][config('constants.DISH_TYPE_OTHER')]['dishPrice']) }} )</span>
                              @else
                                {{ Form::checkbox($dish['dishTypeName'].'_'.strtolower($dishName),$dishId, false) }}
                                <span>{{ $dishName }} ( <i class="fas fa-rupee-sign"></i>{{ round($dish['dishPrice'][$dishId]) }} )</span>
                              @endif
                            </label>
                          </div>
                        @endforeach
                      @endif
                   @endforeach
                 </div>
               @endif
              </div>
            </div>
            <div class="box-footer">
              {{ Form::submit("Submit", ["class" => "btn btn-success pull-right"]) }}
            </div>
            {{ Form::close() }}
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
