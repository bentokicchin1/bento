@extends('admin.layouts.master')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Dashboard<small>Control panel</small></h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @foreach($orders as $order)
            <div class="col-lg-2 col-xs-4">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{$order->dishCount}}</h3>
                        <p>{{$order->dishName}}</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-cutlery"></i>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if(!empty($orderList))
        <div class="box-body" style="overflow-x:auto;">
          <a href="/admin/generate-pdf" class=" btn btn-big btn-success">Export Today's Orders</a>
          <table id="userTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                  <!-- <th>ID</th> -->
                  <th>Name</th>
                  <th>Mobile</th>
                  <th style="width:30%;">Tiffin</th>
                  <th style="width:20%;">Office/Building</th>
                  <th>Sector</th>
                  <th>City</th>
              </tr>
            </thead>
            <tbody>
              @foreach($orderList as $list)
              <tr>
                <td>{{ ucfirst($list['name']) }}</td>
                <td>{{ $list['mobile_number'] }}</td>
                <td>
                  <ul>
                    @foreach($list['menu'] as $val)
                      <li>{{ $val['quantity'].' '.$val['dish'] }}</li>
                    @endforeach
                 </ul>
                </td>
                <td>{{ ucfirst($list['address']) }}</td>
                <td>{{ ucfirst($list['area']) }}</td>
                <td>{{ ucfirst($list['city']) }}</td>
              </tr>
              @endforeach
          </tbody>
        </table>
      </div>
      @endif
    </section>
    {!! Html::script('admin/bower_components/datatables.net/js/jquery.dataTables.min.js') !!}
    {!! Html::script('admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') !!}
    <script>
      $(function () {
        $('#userTable').DataTable({
          'paging'      : true,
          'lengthChange': false,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false
        });
      });
    </script>
@endsection
