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
        <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">
          <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Add Order </h3>
                <a href="{{ url()->previous() }}" class="btn btn-info" style="float:right">Back</a>
            </div>
            <!-- /.box-header -->
            @if(!empty($ordersData))
            {{ Form::model($ordersData, ['route' => ['admin-order-add', $ordersData['id']]]) }}
            {{ Form::hidden('id', $ordersData['id']) }}
            @else
            {{ Form::open(['route' => 'admin-order-add', 'method' => 'post']) }}
            @endif
            <div class="box-body">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label" style="padding-top:7px">Name</label>
                    <div class="col-sm-10">
                            {{ Form::text('name',old('name') , ['id' => 'name', 'class' => 'form-control', 'placeholder' => 'Order Type Name (required)']) }}
                    </div>
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
@endsection
