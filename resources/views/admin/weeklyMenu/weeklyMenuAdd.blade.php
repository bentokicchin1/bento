@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Weekly Menu
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin-dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin-menu-add')}}">Weekly Menu</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-12">
          <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Add Weekly Menu </h3>
                <a href="{{ url()->previous() }}" class="btn btn-info" style="float:right">Back</a>
            </div>
            <!-- /.box-header -->
            {{ Form::open(['route' => 'admin-menu-add', 'method' => 'post' ,'class'=>'form-horizontal']) }}
            {{ Form::hidden('order_type_id', config('constants.ORDER_TYPE_DINNER')) }}
            <div class="box-body">
                <div class="form-group">
                    <label for="menuDate" class="col-sm-3 control-label">Select Day :</label>
                    <div class="col-sm-6">
                      {{ Form::text('menuDate',null,['id'=>'menuDate','class'=>'form-control','placeholder'=>'Date (required)']) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">Select Order Type :</label>
                    <div class="col-sm-6">
                        {{ Form::select('order_type_id',$orderTypeData,null,['id'=>'order_type_id','class'=>'form-control','placeholder'=>'Order Type (required)']) }}
                    </div>
                </div>
                @foreach($dishTypeSelect as $dishType=>$dishData)
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Select {{$dishType}} :</label>
                        <div class="col-sm-6">
                            @php $dishTypeFormat = str_replace(" ","-",$dishType); @endphp
                            {{ Form::select('dish[]',$dishData,null,['id'=>$dishTypeFormat,'multiple'=>'multiple','class'=>'form-control dynamicDish']) }}
                        </div>
                    </div>
                    <div id="divDefault_{{$dishTypeFormat}}"></div>
                @endforeach
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

      <div class="row">
          <div class="col-xs-12">
              <div class="box">
                  <div class="box-header">
                      <h3 class="box-title">{{$tableTitle}}</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body no-padding">
                      @foreach ($menuArray as $dayName=>$menuData)
                        <table class="table">
                          <thead>
                              <th colspan="2"><h4><center>{{ucfirst(date('l',strtotime($dayName)))}}</center></h4></th>
                          </thead>
                          <tbody>
                            <tr>
                              @foreach ($menuData as $orderType=>$menuDetails)
                                <td>
                                  <div class="box">
                                      <div class="box-header">
                                          <h5 class="box-title">{{ucfirst($orderType)}}</h5>
                                      </div>
                                  </div>
                                  <div class="box-body no-padding">
                                      <table class="table">
                                        <tbody>
                                          @foreach ($menuDetails as $dishType=>$dishes)
                                            <tr>
                                              <td><b>{{$dishType}} -</b> {{implode($dishes,", ")}}</td>
                                            </tr>
                                          @endforeach
                                        </tbody>
                                      </table>
                                  </div>
                                </td>
                              @endforeach
                            </tr>
                          </tbody>
                        </table>
                      @endforeach
                  </div>
                  <!-- /.box-body -->
              </div>
            <!-- /.box -->
          </div>
        <!-- /.col -->
      </div>
    </section>
    <script>
      $( document ).ready(function() {
        $(".dynamicDish").select2();

        $(".dynamicDish").on('change',function(){
          var defaultRadio = '';
          var controlId = $(this).attr('id');
          var dishArray = $(this).select2('data');
          $('#divDefault_'+dishType).html(defaultRadio);
          if(!$.isEmptyObject(dishArray)){
            var dishType = controlId.replace(/-/g," ");
            defaultRadio = defaultRadio+'<div class="form-group"><label for="name" class="col-sm-3 control-label">Select Default '+dishType+' :</label><div class="col-sm-6">';
            $.each(dishArray,function(i,val){
              defaultRadio = defaultRadio+'<input class="radio-inline" required="true" name="default['+dishType+']" value="'+val.id+'" type="radio"><label for="default_'+dishType+'">'+val.text+'</label>';
            });
            defaultRadio = defaultRadio+'</div></div>';
          }
          $('#divDefault_'+controlId).html(defaultRadio);
        });

        $("#menuDate").datepicker({
          startDate:new Date(),
          autoclose : true,
          format : 'DD, d MM, yyyy'
        });
      });
    </script>
    <!-- /.content -->
@endsection
