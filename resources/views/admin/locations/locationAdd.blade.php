@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Area Location
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin-location-list')}}">Area Location</a></li>
        <li class="active">Add/Edit Area Location</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">
          <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Add Area Location </h3>
                <a href="{{ url()->previous() }}" class="btn btn-info" style="float:right">Back</a>
            </div>
            <!-- /.box-header -->
            {{ Form::open(['route' => 'admin-location-add', 'method' => 'post' ,'class'=>'form-horizontal','files' => true]) }}
            @if(!empty($areaLocationData))
            {{ Form::model($areaLocationData, ['route' => ['admin-location-add', $areaLocationData['id']]]) }}
            {{ Form::hidden('id', $areaLocationData['id']) }}
            @endif
            <div class="box-body">
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label" style="padding-top:7px">Select Area :</label>
                    <div class="col-sm-6">
                        @if(!empty($areaLocationData))
                            {{ Form::select('areaId',$areaData,$areaLocationData['area_id'],['id'=>'areaId','class'=>'form-control','placeholder'=>'Area (required)']) }}
                        @else
                            {{ Form::select('areaId',$areaData,null,['id'=>'areaId','class'=>'form-control','placeholder'=>'Area (required)']) }}
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label" style="padding-top:7px">Name</label>
                    <div class="col-sm-6">
                            {{ Form::text('name',old('name') , ['id' => 'name', 'class' => 'form-control', 'placeholder' => 'Location Name (required)']) }}
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
