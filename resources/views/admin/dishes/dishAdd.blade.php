@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dish
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin-dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="{{ route('admin-dish-list')}}">Dish</a></li>
        <li class="active">Add/Edit Dish</li>


      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-12">
          <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Add Dish </h3>
                <a href="{{ url()->previous() }}" class="btn btn-info" style="float:right">Back</a>
            </div>
            <!-- /.box-header -->
            {{ Form::open(['route' => 'admin-dish-add', 'method' => 'post' ,'class'=>'form-horizontal','files' => true]) }}
            @if(!empty($dishTypesData))
            {{ Form::model($dishTypesData, ['route' => ['admin-dish-add', $dishTypesData['id']]]) }}
            {{ Form::hidden('id', $dishTypesData['id']) }}
            @endif
            <div class="box-body">
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label" style="padding-top:7px">Select Dish Type :</label>
                    <div class="col-sm-6">
                        @if(!empty($dishTypesData))
                            {{ Form::select('dishTypeId',$dishData,$dishTypesData['dish_type_id'],['id'=>'dishTypeId','class'=>'form-control','placeholder'=>'Dish Type (required)']) }}
                        @else
                            {{ Form::select('dishTypeId',$dishData,null,['id'=>'dishTypeId','class'=>'form-control','placeholder'=>'Dish Type (required)']) }}
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label" style="padding-top:7px">Dish Name :</label>
                    <div class="col-sm-6">
                            {{ Form::text('name',old('name') , ['id' => 'name', 'class' => 'form-control', 'placeholder' => 'Dish Title (required)']) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label" style="padding-top:7px">Dish Price :</label>
                    <div class="col-sm-6">
                            {{ Form::text('price',old('price') , ['id' => 'price', 'class' => 'form-control', 'placeholder' => 'Dish Price (required)']) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label" style="padding-top:7px">Dish Image :</label>
                    <div class="col-sm-6">
                            {{ Form::file('dishImage',null,['id' => 'dishImage', 'class' => 'form-control', 'placeholder' => 'Select Dish Image']) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label" style="padding-top:7px">Dish Description :</label>
                    <div class="col-sm-6">
                            {{ Form::textarea('description',old('description') , ['id' => 'description', 'class' => 'form-control', 'placeholder' => 'Dish Description']) }}
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
