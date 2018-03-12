@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <script type="text/javascript">
    var menuEvents = {!! $menuArray !!}
    </script>

    <section class="content-header">
      <h1>
         Weekly Menu
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin-dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Weekly Menu</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
            <a href="{{ route('admin-menu-add')}}" class=" btn btn-big btn-success">Add Menu</a>
            </div>
            <!-- /.box-header -->
            <div  id="areaTable"></div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    <!-- DataTables -->
    {!! Html::script('admin/bower_components/datatables.net/js/jquery.dataTables.min.js') !!}
    {!! Html::script('admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') !!}
    <script>
      $(function () {
        var date = new Date()
        var d    = date.getDate(),
            m    = date.getMonth(),
            y    = date.getFullYear()
          $('#areaTable').fullCalendar({
              header    : {
                left  : 'prev,next today',
                center: 'title',
                right : 'month,listDay,listWeek'
              },
              buttonText: {
                today: 'today',
                month: 'month',
                week : 'week',
                day  : 'day'
              },
              defaultView: 'listWeek',
              events    : menuEvents,
              editable  : true,
              droppable : true
          });
      });
    </script>
@endsection
