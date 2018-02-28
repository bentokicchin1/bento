@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Order Types
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              {{--  <h3 class="box-title">Data Table With Full Features</h3>  --}}
            <a href="{{ route('admin-order-type-add')}}" class=" btn btn-big btn-success">Add New</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Operation</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orderType as $type)
                <tr>                 
                <td>{{$type->id}}</td>
                <td>{{ ucfirst($type->name) }}</td>
                <td><a class="btn btn-warning" href="{{ route('admin-order-type-edit',['id' => $type['id']]) }}">Edit</a>
                    <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')" href="{{ route('admin-order-type-delete', ['id' => $type['id']]) }}">Delete</a></div>
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

@endsection    