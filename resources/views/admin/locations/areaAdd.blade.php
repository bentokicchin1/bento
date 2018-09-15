@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Area
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin-dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="{{ route('admin-area-list')}}">Area</a></li>
        <li class="active">Add/Edit Area</li>


      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-12">
          <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Add Area </h3>
                <a href="{{ url()->previous() }}" class="btn btn-info" style="float:right">Back</a>
            </div>
            <!-- /.box-header -->
            {{ Form::open(['route' => 'admin-area-add', 'method' => 'post' ,'class'=>'form-horizontal','files' => true]) }}
            @if(!empty($areaData))
            {{ Form::model($areaData, ['route' => ['admin-area-add', $areaData['id']]]) }}
            {{ Form::hidden('id', $areaData['id']) }}
            @endif
            <div class="box-body">
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label" style="padding-top:7px">Area Name :</label>
                    <div class="col-sm-6">
                            {{ Form::text('name',old('name') , ['id' => 'name', 'class' => 'form-control', 'placeholder' => 'Area Title (required)']) }}
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
