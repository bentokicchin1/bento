@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dish
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin-dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Dish</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              {{--  <h3 class="box-title">Data Table With Full Features</h3>  --}}
            <a href="{{ route('admin-dish-add')}}" class=" btn btn-big btn-success">Add Dish</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="dishTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Dish Type</th>
                  <th>Dish Title</th>
                  <th>Dish Price</th>
                  <th>Dish Image</th>
                  <th>Dish Description</th>
                  <th>Operation</th>
                </tr>
                </thead>
                <tbody>
                @foreach($dishType as $type)
                <tr>
                  <td>{{$type->id}}</td>
                  <td>{{$type->dishtype->name}}</td>
                  <td>{{ ucfirst($type->name) }}</td>
                  <td>{{ $type->price }}</td>
                  <td><img src="{{ $type->image }}" height="50" width="50"/></td>
                    <td>{{ $type->description }}</td>
                  <td><a class="btn btn-warning" href="{{ route('admin-dish-edit',['id' => $type['id']]) }}">Edit</a>
                      <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')" href="{{ route('admin-dish-delete', ['id' => $type['id']]) }}">Delete</a></div>
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
        $('#dishTable').DataTable({
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
