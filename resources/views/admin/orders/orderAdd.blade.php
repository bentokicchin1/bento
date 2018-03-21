@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Order
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
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
            {{ Form::model($ordersData, ['route' => ['admin-order-add', $ordersData->id]]) }}
            {{ Form::hidden('id',  $ordersData->id) }}
            @endif
            <div class="box-body">
              <div class="form-group">
                  <label for="user" class="col-sm-3 control-label" style="padding-top:7px">User</label>
                  <div class="col-sm-6">
                    @if(!empty($ordersData))
                      {{ Form::label('',$ordersData->users->name,array('class' => 'form-control')) }}
                    @else
                      {{ Form::select('user',$userData,null,['id'=>'user','required'=>true,'class'=>'form-control dropdown','placeholder'=>'User (required)']) }}
                    @endif
                  </div>
              </div>
              <div class="form-group">
                  <label for="menuDate" class="col-sm-3 control-label" style="padding-top:7px">Select Day :</label>
                  <div class="col-sm-6">
                    @if(!empty($ordersData))
                        {{ Form::label('',date('l,d F,Y',strtotime($ordersData->created_at)),array('class' => 'form-control')) }}
                    @else
                      {{ Form::text('orderDate',null,['id'=>'orderDate','required'=>true,'class'=>'form-control','placeholder'=>'Date (required)']) }}
                    @endif
                  </div>
              </div>
              <div class="form-group">
                  <label for="order_type_id" class="col-sm-3 control-label" style="padding-top:7px">Order Type</label>
                  <div class="col-sm-6">
                    @if(!empty($ordersData))
                      {{ Form::label('',$ordersData->orderType->name,array('class' => 'form-control')) }}
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
                                  {{ Form::select($dish['dishTypeName'], $dish['dishList'], '', ['class' => 'form-control drpdown','placeholder' => 'Please select '.$dish['dishTypeName'] ])}}
                                </div>
                                <div class="col-sm-3">
                                  {{ Form::text('qty_'.$dish['dishTypeName'],old('qty_'.$dish['dishTypeName']) , ['class' => 'form-control text', 'placeholder' => 'Quantity']) }}
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
                        </div>
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
