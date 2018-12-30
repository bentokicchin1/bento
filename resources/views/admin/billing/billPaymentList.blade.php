@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Payments
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin-dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active"> Payments</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-MD-12">
          <div class="box">
            <div class="box-header with-border">
              <a href="{{ route('admin-billpayment-add')}}" class=" btn btn-big btn-success">Add Payments</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="overflow-x:auto;">
              <table id="billpaymentTable" class="table table-bordered table-striped">
                <tr>
                    <th>Payments Date</th>
                    <th>Billing Cycle</th>
                    <th>Payments Received</th>
                    <th>Payments Mode</th>
                    <th>Amount Pending</th>
                    <th>Action</th>
                </tr>
                  @foreach($payments as $type)
                  <tr>
                    <td>{{ date('d M Y',strtotime($type['payment_date'])) }}</td>
                    <td>{{$type['users']['billing_cycle']}}</td>
                    <td>{{ $type['payment_received'] }}</td>
                    <td>{{$type['mode_of_payment']}}</td>
                    <td>{{ $type['outstanding_bill'] }}</td>
                    <td>
                      <!-- <a class="btn btn-warning" href="{{ route('admin-billpayment-edit',['id' => $type['id']]) }}">Edit</a> -->
                      <!-- <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')" href="{{ route('admin-billpayment-delete', ['id' => $type['id']]) }}">Delete</a></div> -->
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
        $('#billpaymentTable').DataTable({
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
