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
                  <th>Tiffin</th>
                  <th>Office/Building</th>
                  <th>Sector</th>
                  <th>Location</th>
              </tr>
            </thead>
            <tbody>
              @foreach($orderList as $orders)
                $orderItems = '';
                @foreach($orders['order_items'] as $items)
                  $orderItems .= $items['dish_id'] .'*'. $items['quantity'] .",";
                @endforeach
              <tr>
                <td>{{ ucfirst($orders['users']['name']) }}</td>
                <td>{{ $orders['users']['mobile_number'] }}</td>
                <td>{{ $orderItems }}</td>
                <td>{{ ucfirst($orders['shipping_address']['location']) }}</td>
                <td>{{ ucfirst($orders['shipping_address']['area_location']['name']) }}</td>
                <td>{{ ucfirst($orders['shipping_address']['area_data']['name']) }}</td>
              </tr>
              @endforeach
          </tbody>
        </table>
      </div>
      @endif
    </section>
@endsection
