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
    <section class="content">
      <div class="row">
        <div class="col-md-offset-1 col-md-10 col-sm-12">
          <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Add Order </h3>
                <a href="{{ url()->previous() }}" class="btn btn-info" style="float:right">Back</a>
            </div>
            <!-- /.box-header -->
            {{ Form::open(['route' => 'admin-order-add', 'method' => 'post' ,'class'=>'form-horizontal']) }}
            @if(!empty($ordersData))
            {{ Form::model($ordersData, ['route' => ['admin-order-add', $ordersData['id']]]) }}
            {{ Form::hidden('id', $ordersData['id']) }}
            @endif
            <div class="box-body">
                <div class="form-group">
                    <label for="user" class="col-sm-3 control-label" style="padding-top:7px">User</label>
                    <div class="col-sm-6">
                        {{ Form::select('user',$userData,old('user_id'),['id'=>'user','class'=>'form-control']) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="order_type_id" class="col-sm-3 control-label" style="padding-top:7px">Order Type</label>
                    <div class="col-sm-6">
                        {{ Form::select('orderTypeId',$orderTypeData,null,['id'=>'orderTypeId','class'=>'form-control','placeholder'=>'Order Type (required)']) }}
                    </div>
                </div>
                <label class="col-sm-3 control-label" style="padding-top:7px">Order Details</label>
                <div class="row  col-sm-6">
                      @if(!empty($dishData))
                          @foreach ($dishData as $dish)
                            @if ($dish['dishTypeName'] != 'others')
                              <div class="form-group">
                                <div class="col-sm-6">
                                  {{ Form::select($dish['dishTypeName'], $dish['dishList'], '', ['class' => 'form-control','placeholder' => 'Please select '.$dish['dishTypeName'] ])}}
                                </div>
                                <div class="col-sm-3">
                                  {{ Form::text('qty_'.$dish['dishTypeName'],old('qty_'.$dish['dishTypeName']) , ['class' => 'form-control', 'placeholder' => 'Quantity']) }}
                                </div>
                            </div>
                            @else
                              <div class="checkbox">
                                  @php
                                      foreach($dish['dishList'] as $dishId => $dishName){
                                  @endphp
                                      <label>
                                          {{ Form::checkbox($dish['dishTypeName'].'_'.strtolower($dishName), $dishId, true) }}
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
                        @else
                          <h4 style="text-align:center;">No data found</h4>
                        @endif
                    </div>
                </div>
            <!-- /.box-body -->
            <div class="box-footer">
                {{ Form::submit('Submit', ['class' => 'btn btn-success pull-right']) }}
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
    <script>
      $( document ).ready(function() {
        $("#user,#order_type_id").select2();
      });
    </script>
@endsection
