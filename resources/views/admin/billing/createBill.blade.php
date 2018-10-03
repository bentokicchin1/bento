@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <style>
    .form-horizontal .control-label{
        /* text-align:right; */
        text-align:left;
    }
    </style>
    <section class="content-header">
      <h1>
        Format Bills
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin-dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="{{ route('admin-billformat-create')}}">Format Bills</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12 col-sm-12">
          <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Create Bill Format</h3>
                <a href="{{ url()->previous() }}" class="btn btn-info" style="float:right">Back</a>
            </div>
            <!-- /.box-header -->
            {{ Form::open(['route' => 'admin-billformat-create', 'method' => 'post' ,'class'=>'form-horizontal','id'=>'billformat']) }}
            <div class="box-body">
              <div class="col-sm-12">
                <div class="form-group col-sm-6">
                    <label for="menuDate" class="col-sm-6 control-label">select Tiffin Type :</label>
                    <div class="col-sm-6">
                      {{ Form::select('tiffinType',$tiffintype,null,['id'=>'tiffinType','class'=>'form-control','placeholder'=>'Tiffin Type (required)']) }}
                    </div>
                </div>
                <div class="form-group col-sm-6">
                    <label for="name" class="col-sm-6 control-label">Select Food Preference :</label>
                    <div class="col-sm-6">
                      {{ Form::select('foodPreference',$foodPreference,null,['id'=>'foodPreference','class'=>'form-control','placeholder'=>'Food Preference (required)']) }}
                    </div>
                </div>
                <div class="col-sm-offset-3 col-sm-6">
                    <label for="name" class="col-sm-6 control-label">Enter Pending Bill Amount :</label>
                    <div class="col-sm-6">
                      {{ Form::text('pendingAmount',0,null,['id'=>'pendingAmount','class'=>'form-control','placeholder'=>'Pending Bill Amount (required)']) }}
                    </div>
                </div>
              </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Enter Details :- </h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            @foreach ($dates as $day)
                              <div class="form-group col-sm-3">
                                  <div class="col-sm-2">
                                    {{ Form::checkbox('days[]',date('Y-m-d',strtotime($day)), true,[]) }}
                                  </div>
                                  <label for="days[]" class="col-sm-9 control-label">{{date('l, d M',strtotime($day))}}</label>
                              </div>
                            @endforeach
                        </div>
                        <!-- /.box-body -->
                    </div>
                  <!-- /.box -->
                </div>
              <!-- /.col -->
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
    <script>
      var billAmount = 0;
      $( document ).ready(function() {
        var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
        $("#billformat").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var tiffinAmount = 0;var tiffinPrice = 0;
            var tiffinType = $('#tiffinType').val();
            var foodPreference = $('#foodPreference').val();
            var pendingBill = $('#pendingAmount').val();
            $.each($("input[name='days[]']:checked"), function() {
              var a = new Date($(this).val());
              var selectedDay = weekday[a.getDay()];
              tiffinPrice = (tiffinType==="half") ? 45 : 60;
              if(foodPreference=='nonveg' && selectedDay=='Friday'){
                tiffinPrice = (tiffinType==="half") ? 60 : 75;
              }
              tiffinAmount += tiffinPrice;
            });
            alert(tiffinAmount);

        });
      });
    </script>
    <!-- /.content -->
@endsection
