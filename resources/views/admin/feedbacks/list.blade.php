@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Feedbacks
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin-dashboard')}}"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#" class="active">Feedback List</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="overflow-x:auto;">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Mobile</th>
                  <th>Comment</th>
                  <th>Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach($feedbacks as $comment)
                <tr>
                  <td>{{ ucfirst($comment['users']['name']) }}</td>
                  <td>{{$comment['users']['mobile_number']}}</td>
                  <td>{{$comment['value']}}</td>
                  <td>{{ date('Y-m-d h:i a',strtotime($comment['created_at']))}}</td>
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
