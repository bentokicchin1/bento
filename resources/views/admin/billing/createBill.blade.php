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
                      {{ Form::select('tiffinType',$tiffintype,null,['id'=>'tiffinType','class'=>'form-control','placeholder'=>'Tiffin Type (required)','required'=>true]) }}
                    </div>
                </div>
                <div class="form-group col-sm-6">
                    <label for="name" class="col-sm-6 control-label">Select Food Preference :</label>
                    <div class="col-sm-6">
                      {{ Form::select('foodPreference',$foodPreference,null,['id'=>'foodPreference','class'=>'form-control','placeholder'=>'Food Preference (required)','required'=>true]) }}
                    </div>
                </div>
                <div class="col-sm-offset-3 col-sm-6">
                    <label for="name" class="col-sm-6 control-label">Enter Pending Bill Amount :</label>
                    <div class="col-sm-6">
                      {{ Form::text('pendingAmount',0,['id'=>'pendingAmount','class'=>'form-control','placeholder'=>'Pending Bill Amount (required)','required'=>true]) }}
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
                                    {{ Form::checkbox('days[]',date('Y-m-d',strtotime($day)), true,['id'=>date('Y-m-d',strtotime($day))]) }}
                                  </div>
                                  <label for="{{date('Y-m-d',strtotime($day))}}" class="col-sm-9 control-label">{{date('l, d M',strtotime($day))}}</label>
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
      <div class="modal fade" id="billModal" tabindex="-1" role="dialog" aria-labelledby="billModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Your Bill Is Ready</h4>
            </div>
            <div class="modal-body"><div class="createdBill"></div></div>
            <div class="modal-footer"></div>
          </div>
        </div>
    </div>
      <!-- /.row -->
    </section>
    <script>
      var billAmount = 0;
      $( document ).ready(function() {
        var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
        // var messageFormat = "<p>Hi,</p><p>Total tiffins count of September 2018 = [totalTiffin]</p><p>Veg Tiffins On ([vegTiffinDates])</p><p>Non Veg Tiffins On ([nonvegTiffinDates])</p><p>Previous unbilled amount = [pendingAmount]<br />Current unbilled amount = [totalBillAmount]<br />Total unbilled amount = [grandTotal]</p><p>Thanks and Regards<br />Bento</p>";

        $("#billformat").submit(function(e) {
            var messageFormat = "<p>Hi,</p><p>Total tiffins count of September 2018 = [totalTiffin] </p><p>Veg Tiffins On ([vegTiffinDates])</p><p>Non Veg Tiffins On ([nonvegTiffinDates])</p><p>Previous unbilled amount = [pendingAmount] <br />Current unbilled amount = [totalBillAmount] <br />Total unbilled amount = [grandTotal] </p><p>Thanks and Regards<br />Bento</p>";

            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var formattedText = '';
            var vegTiffinDates = [];var nonvegTiffinDates = [];
            var tiffinAmount = 0;var tiffinPrice = 0;
            var tiffinType = $('#tiffinType').val();
            var foodPreference = $('#foodPreference').val();
            var pendingBill = $('#pendingAmount').val();
            messageFormat = messageFormat.replace("[pendingAmount]", pendingBill);
            var totalTiffin = $("input[name='days[]']:checked").length;
            messageFormat = messageFormat.replace("[totalTiffin]", totalTiffin);
            $.each($("input[name='days[]']:checked"), function() {
              var a = new Date($(this).val());
              var selectedDay = weekday[a.getDay()];
              tiffinPrice = (tiffinType==="half") ? 45 : 60;
              if(foodPreference=='nonveg' && selectedDay=='Friday'){
                tiffinPrice = (tiffinType==="half") ? 60 : 75;
                nonvegTiffinDates.push(a.getDate());
              }else{
                vegTiffinDates.push(a.getDate());
              }
              tiffinAmount += tiffinPrice;
            });
            messageFormat = messageFormat.replace("[vegTiffinDates]", vegTiffinDates.join());
            messageFormat = messageFormat.replace("[nonvegTiffinDates]", nonvegTiffinDates.join());
            messageFormat = messageFormat.replace("[totalBillAmount]", tiffinAmount);
            var grandTotal = parseInt(tiffinAmount) + parseInt(pendingBill);
            messageFormat = messageFormat.replace("[grandTotal]", grandTotal);
            $('#billModal').modal('show');
            $('.createdBill').html(messageFormat);
        });
      });
    </script>
    <!-- /.content -->
@endsection
