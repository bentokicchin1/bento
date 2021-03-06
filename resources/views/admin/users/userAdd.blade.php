@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin-dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="{{ route('admin-user-list')}}">User</a></li>
        <li class="active">Add User</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-12">
          <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Add User </h3>
                <a href="{{ url()->previous() }}" class="btn btn-info" style="float:right">Back</a>
            </div>
            <!-- /.box-header -->
            {{ Form::open(['route' => 'admin-user-add', 'method' => 'post' ,'class'=>'form-horizontal']) }}
            @if(!empty($usersData))
            {{ Form::model($usersData, ['route' => ['admin-user-add', $usersData->id]]) }}
            {{ Form::hidden('id', $usersData->id) }}
            @endif
            <div class="box-body">
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label" style="padding-top:7px">User Name :</label>
                    <div class="col-sm-6">
                            {{ Form::text('name',old('name') , ['id' => 'name', 'class' => 'form-control', 'placeholder' => 'User Name (required)']) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label" style="padding-top:7px">User Mobile :</label>
                    <div class="col-sm-6">
                          {{ Form::checkbox('mobile_verified', 1, old('mobile_verified'), ['class' => 'checkbox-inline']) }}
                          {!! Form::label('mobile_verified', 'Is Mobile Verified') !!}
                          {{ Form::text('mobile_number',old('mobile_number') , ['id' => 'mobile_number', 'class' => 'form-control', 'placeholder' => 'User Mobile (required)']) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label" style="padding-top:7px">User Billing Cycle :</label>
                    <div class="col-sm-6">
                          {!! Form::label('daily', 'Daily') !!}
                          {{ Form::radio('billing_cycle', 'daily',old('billing_cycle'),['class'=>'radio-inline']) }}
                          {!! Form::label('monthly', 'Monthly') !!}
                          {{ Form::radio('billing_cycle', 'monthly',old('billing_cycle'),['class'=>'radio-inline']) }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label" style="padding-top:7px">User Food Preference :</label>
                    <div class="col-sm-6">
                          {!! Form::label('veg', 'Veg') !!}
                          {{ Form::radio('food_preference', 'veg',old('food_preference'),['class'=>'radio-inline']) }}
                          {!! Form::label('nonveg', 'Non-Veg') !!}
                          {{ Form::radio('food_preference', 'nonveg',old('food_preference'),['class'=>'radio-inline']) }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label" style="padding-top:7px">User Tiffin Quantity :</label>
                    <div class="col-sm-6">
                          {!! Form::label('half', 'Half') !!}
                          {{ Form::radio('tiffin_quantity', 'half',old('tiffin_quantity'),['class'=>'radio-inline']) }}
                          {!! Form::label('full', 'Full') !!}
                          {{ Form::radio('tiffin_quantity', 'full',old('tiffin_quantity'),['class'=>'radio-inline']) }}
                    </div>
                </div>
                <div class="col-md-8 col-sm-10 box">
                  <h4 class="m-b-20">Address</h4>
                  <div class="form-group">
                      <label for="name" class="col-sm-3 control-label" style="padding-top:7px">Select Order Type :</label>
                      <div class="col-sm-6">
                            {{ Form::select('order_type_id',$orderTypeData,old('order_type_id'),['class' => 'form-control dropdown','placeholder' => 'Please Select Order Type' ]) }}
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="name" class="col-sm-3 control-label" style="padding-top:7px">Select City :</label>
                      <div class="col-sm-6">
                        {{ Form::select('city', $cityData,old('city'), ['class' => 'form-control dropdown','placeholder' => 'Please Select Your City'])}}
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="name" class="col-sm-3 control-label" style="padding-top:7px">Select Area :</label>
                      <div class="col-sm-6">
                        {{ Form::select('area',$areaData,old('area'), ['class' => 'form-control dropdown','placeholder' => 'Please Select Your Area' ])}}
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="name" class="col-sm-3 control-label" style="padding-top:7px">Select Sector :</label>
                      <div class="col-sm-6">
                        {{ Form::select('sector',$areaLocationData, old('sector'), ['class' => 'form-control dropdown','placeholder' => 'Please Select Your Sector' ])}}
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="name" class="col-sm-3 control-label" style="padding-top:7px">Office Name/Building Name :</label>
                      <div class="col-sm-6">
                        {{ Form::text('location',old('location') , ['class' => 'form-control', 'placeholder' => 'Office Name/Building Name (required)']) }}
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="name" class="col-sm-3 control-label" style="padding-top:7px">Select State :</label>
                      <div class="col-sm-6">
                        {{ Form::text('state','Maharashtra' , ['class' => 'form-control', 'placeholder' => 'State (required)', 'readonly']) }}
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="name" class="col-sm-3 control-label" style="padding-top:7px">Enter Pincode :</label>
                      <div class="col-sm-6">
                        {{ Form::text('pincode',old('pincode'), ['class' => 'form-control', 'placeholder' => 'Pincode (required)']) }}
                      </div>
                  </div>
                </div>

            </div>
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
