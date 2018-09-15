@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Area
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin-dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active"> Area</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              {{--  <h3 class="box-title">Data Table With Full Features</h3>  --}}
            <a href="{{ route('admin-area-add')}}" class=" btn btn-big btn-success">Add Area</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="areaTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Area Title</th>
                  <th>Operation</th>
                </tr>
                </thead>
                <tbody>
                @foreach($area as $type)
                <tr>
                  <td>{{$type->id}}</td>
                  <td>{{ ucfirst($type->name) }}</td>
                  <td><a class="btn btn-warning" href="{{ route('admin-area-edit',['id' => $type['id']]) }}">Edit</a>
                      <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')" href="{{ route('admin-area-delete', ['id' => $type['id']]) }}">Delete</a></div>
                  </td>
                </tr>
                @endforeach
                </tbody>
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
        $('#areaTable').DataTable({
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
