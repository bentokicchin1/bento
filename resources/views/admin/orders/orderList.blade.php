@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Order
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin-dashboard')}}"><i class="fas fa-home"></i> Home</a></li>
        <li class="active"> Order</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <a href="{{ route('admin-order-add')}}" class=" btn btn-big btn-success">Add Order</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="orderTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>User Name</th>
                    <th>Tiffin Frequency</th>
                    <th>Orderd For Date</th>
                    <th>Order Type</th>
                    <th>Order Amount</th>
                    <th>Delivery Address</th>
                    <th>Order Status</th>
                    <th>Operation</th>
                </tr>
              </thead>
                  @foreach($orders as $order)
                  <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->users->name}}</td>
                    <td>{{$order->users->billing_cycle}}</td>
                    <td>{{date('j-M-Y', strtotime($order->created_at))}}</td>
                    <td>{{ucfirst($order->orderType->name)}}</td>
                    <td>{{$order->total_amount}}</td>
                    <td style="width:50px;">
                      @if(!is_null($order->shipping_address->address_type)) {{$order->shipping_address->address_type}} @endif
                      - {{$order->shipping_address->location}},
                      @if(!is_null($order->shipping_address->areaLocation)) {{$order->shipping_address->areaLocation->name}}, @endif
                      @if(!is_null($order->shipping_address->areaData)) {{$order->shipping_address->areaData->name}}, @endif
                      @if(!is_null($order->shipping_address->cityData)) {{$order->shipping_address->cityData->name}}, @endif
                      {{$order->shipping_address->pincode}}</td>
                    <td>{{$order->status}}</td>
                    <td><a class="btn btn-warning" href="{{ route('admin-order-edit',['id' =>$order->id]) }}">Edit</a>
                        <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')" href="{{ route('admin-order-delete', ['id' => $order->id]) }}">Delete</a></div>
                    </td>
                  </tr>
                  @endforeach
              </table>
            </div>
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
        $('#orderTable').DataTable({
          'paging'      : true,
          'lengthChange': false,
          'deferRender' : true,
          'scrollX'     : true,
          'scrollCollapse': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false
        });
      });
    </script>
@endsection
