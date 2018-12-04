@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dish Types
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin-dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#"class="active">Dish Type</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              {{--  <h3 class="box-title">Data Table With Full Features</h3>  --}}
            <a href="{{ route('admin-dish-type-add')}}" class=" btn btn-big btn-success">Add DishType</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="overflow-x:auto;">
              <table id="dishTypeTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Food Type</th>
                  <th>Operation</th>
                </tr>
                </thead>
                <tbody>
                @foreach($dishType as $type)
                <tr>
                  <td>{{$type->id}}</td>
                  <td>{{ ucfirst($type->name) }}</td>
                  <td>{{ ucfirst($type->food_type) }}</td>
                  <td><a class="btn btn-warning" href="{{ route('admin-dish-type-edit',['id' => $type['id']]) }}">Edit</a>
                      <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')" href="{{ route('admin-dish-type-delete', ['id' => $type['id']]) }}">Delete</a></div>
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
        $('#dishTypeTable').DataTable({
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
