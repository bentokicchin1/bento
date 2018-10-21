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
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{$order->dishCount}}</h3>
                        <h2>{{$order->dishName}}</h2>
                        <p>{{$order->dishType}}</p>
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
                  <th>Billing Cycle</th>
                  <th>Food Preference</th>
                  <th>Tiffin Quantity</th>
                  <th>Location</th>
                  <th>Sector</th>
              </tr>
            </thead>
            <tbody>
              @foreach($orderList as $orders)
              <tr>
                <td></td>
              </tr>
              @endforeach
          </tbody>
        </table>
      </div>
      @endif
    </section>
@endsection
