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
            {{ Form::model($ordersData, ['route' => ['admin-order-add', $ordersData['id']]]) }}
            {{ Form::hidden('id', $ordersData['id']) }}
            @endif
            <div class="box-body">
              <div class="form-group">
                  <label for="user" class="col-sm-3 control-label" style="padding-top:7px">User</label>
                  <div class="col-sm-6">
                      {{ Form::select('user',$userData,old('user_id'),['id'=>'user','required'=>true,'class'=>'form-control dropdown','placeholder'=>'User (required)']) }}
                  </div>
              </div>
              <div id="addressRadio"></div>
              <div id="orderRequiredDetails" style="display:none;">
                <div class="form-group">
                    <label for="menuDate" class="col-sm-3 control-label" style="padding-top:7px">Select Day :</label>
                    <div class="col-sm-6">
                      {{ Form::text('orderDate',null,['id'=>'orderDate','required'=>true,'class'=>'form-control','placeholder'=>'Date (required)']) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="order_type_id" class="col-sm-3 control-label" style="padding-top:7px">Order Type</label>
                    <div class="col-sm-6">
                        {{ Form::select('orderTypeId',$orderTypeData,null,['id'=>'orderTypeId','required'=>true,'class'=>'form-control dropdown','placeholder'=>'Order Type (required)']) }}
                    </div>
                </div>
              </div>
              <div id="dishDetails"></div>
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
