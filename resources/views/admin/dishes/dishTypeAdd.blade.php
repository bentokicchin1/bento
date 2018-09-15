@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dish Type
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin-dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="{{ route('admin-dish-type-list')}}">Dish Type</a></li>
        <li class="active">Add/Edit Dish Type</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">
          <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Add Dish Type </h3>
                <a href="{{ url()->previous() }}" class="btn btn-info" style="float:right">Back</a>
            </div>
            <!-- /.box-header -->
            {{ Form::open(['route' => 'admin-dish-type-add' ,'class'=>'form-horizontal', 'method' => 'post']) }}
            @if(!empty($dishTypesData))
            {{ Form::model($dishTypesData, ['route' => ['admin-dish-type-add', $dishTypesData['id']]]) }}
            {{ Form::hidden('id', $dishTypesData['id']) }}
            @endif
            <div class="box-body">
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label" style="padding-top:7px">Name :</label>
                    <div class="col-sm-6">
                        {{ Form::text('name',old('name') , ['id' => 'name', 'class' => 'form-control', 'placeholder' => 'Order Type Name (required)']) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label" style="padding-top:7px">Food Type :</label>
                    <div class="col-sm-6">
                        {{ Form::select('food_type',$food_type,old('food_type'),['id'=>'food_type','class'=>'form-control','placeholder'=>'Food Type (required)']) }}
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
