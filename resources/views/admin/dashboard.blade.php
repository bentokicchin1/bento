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
        <div class="box-body">
          <table id="userTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                  <!-- <th>ID</th> -->
                  <th>Name</th>
                  <th>Mobile</th>
                  <th>Tiffin</th>
                  <th>Office/Building</th>
                  <th>Sector</th>
                  <th>Location</th>
              </tr>
            </thead>
            <tbody>
              @foreach($orderList as $list)
              <tr>
                <td>{{ ucfirst($list['name']) }}</td>
                <td>{{ $list['mobile_number'] }}</td>
                <td>{{ $list['menu'] }}</td>
                <td>{{ ucfirst($list['address']) }}</td>
              </tr>
              @endforeach
          </tbody>
        </table>
      </div>
      @endif
    </section>
@endsection
