@extends('layouts.master')
@section('content')

<section id="web">
    <div class="container">
        <div class="row content">

            <div class="col-md-3 col-sm-12 ">
                <ul class="ma-nav ">
                    <li id="profile" class="md-12 sm-2 ">
                        <a href="{{route('profile')}}">
                            <strong>My Profile</strong>
                            <span>Name, Phone, Password</span>
                        </a>
                    </li>
                    <li id="myorders" class="md-12 sm-2 ">
                        <a class="active" href="{{ route('orders')}}">
                            <strong>View My Orders</strong>
                            <span>Check Order Items</span>
                        </a>
                    </li>

                    <li id="address" class="md-12 sm-2 ">
                        <a href="{{route('address')}}">
                            <strong>My Address Book</strong>
                            <span>Add, Edit Addresses</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-md-9 col-sm-12">
                <div class="container-fluid">
                    <div class="row">
                        <div class="order-content col-md-12 col-md-12">
                            @if ($orders['total'] != 0)<div class="heading">Your Total Order Count is <b> {{ $orders['total'] }}</b></div>@endif
                            @if ($orders['total'] == 0)
                                <div class="big-message">You have not placed any order till now.</div>
                            @else
                              <table id="orderTable" class="table table-bordered table-striped">
                                <thead>
                                  <tr>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Type</th>
                                    <th>Items</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach($orders as $order)
                                    @if (is_array($order))
                                      @php
                                        $currentTime= date('h:i a');
                                        $statusClass = ($order['status']=='ordered') ?  'label label-success' : 'label label-danger';
                                      @endphp
                                      <tr>
                                        <td>{{date('j-M-Y', strtotime($order['created_at']))}}</td>
                                        <td><span class='{{$statusClass}}'>{{ ucfirst( $order['status'] ) }}</span></td>
                                        <td>{{ ucfirst( $order['orderTypeName'] ) }}</td>
                                        <td>
                                          @if (is_array($order['dishList']))
                                          <ul>
                                            @foreach($order['dishList'] as $dish)
                                                <li>{{ $dish['dishName'].' x '.$dish['quantity']. ' ' }}</li>
                                            @endforeach
                                          </ul>
                                          @endif
                                        </td>
                                        <td>{{$order['total_amount']}}</td>
                                        <td>
                                          @if((($order['orderTypeId']==config('constants.ORDER_TYPE_LUNCH') && strtotime($currentTime)<=strtotime(config('constants.LUNCH_ORDER_MAX_TIME'))) || ($order['orderTypeId']==config('constants.ORDER_TYPE_DINNER') && strtotime($currentTime)<=strtotime(config('constants.DINNER_ORDER_MAX_TIME')))) && $order['status']!='cancelled') 
                                            <a href="{{ route('order', ['type'=>$order['orderTypeName']]) }}">Edit</a>/<a onclick="return confirm('Are you sure you want to cancel?')" href="{{ route('orderCancel', ['id'=>$order['id']]) }}">Cancel</a>
                                          @else
                                            <span class='label label-info'>Completed</span>
                                          @endif
                                        </td>
                                      </tr>
                                    @endif
                                  @endforeach
                                </tbody>
                            </table>
                          @endif
                        </div>
                    </div>
                </div>
                <div class="text-center">
                </div>
            </div>
        </div>
    </div>
</section>
{!! Html::script('admin/bower_components/datatables.net/js/jquery.dataTables.min.js') !!}
{!! Html::script('admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') !!}
<script>
  $(function () {
    $('#orderTable').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
  });
</script>

@endsection
