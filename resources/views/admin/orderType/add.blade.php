@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Order Type
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin-dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="{{route('admin-order-type-list')}}">Order Type</a></li>
        <li class="active">Add Order Type</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">
          <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Add New </h3>
                <a href="{{ url()->previous() }}" class="btn btn-info" style="float:right">Back</a>
            </div>
            <!-- /.box-header -->
            @if(!empty($orderTypesData))
            {{ Form::model($orderTypesData, ['route' => ['admin-order-type-add', $orderTypesData['id']]]) }}
            {{ Form::hidden('id', $orderTypesData['id']) }}
            @else
            {{ Form::open(['route' => 'admin-order-type-add', 'method' => 'post']) }}
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
