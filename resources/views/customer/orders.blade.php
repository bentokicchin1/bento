@extends('layouts.master')
@section('content')

<section id="web">
    <div class="container">
        <div class="row content">

            <div class="col-md-2 col-sm-12 ">                        
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
                            <span>Check Past Order Items</span>
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

            <div class="col-md-10 col-sm-12">
                <div class="container-fluid">
                    <div class="row">                       
                        <div class="order-content col-md-12 col-md-12">

                            <div class="heading">Your Total Order Count is <b>{{ $orders->total() }}</b></div>
                            @if (empty($orders))
                                <div class="big-message">You have not placed any order till now.</div>
                            @else
                                <div class="col-md-12 col-md-12 sub-heading">
                                    <div class="col-md-1 col-sm-2">ID</div>
                                    <div class="col-md-2 col-sm-2">Date</div>
                                    <div class="col-md-2 col-sm-2">Status</div>
                                    <div class="col-md-2 col-sm-2">Type</div>
                                    <div class="col-md-4 col-sm-2">Items</div>
                                    <div class="col-md-1 col-sm-2">Amount</div>
                                </div>
                                {{--  @inject('orderType','App\Model\OrderType')          --}}
                                @foreach($orders as $order)
                                {{--  {{dd($order)}}  --}}
                                <div class="col-md-12 col-md-12 order-items">
                                    <div class="col-md-1 col-sm-2" style="font-weight:400">
                                        <span>{{$order->id}}</span>
                                    </div>
                                    <div class="col-md-2 col-sm-2" style="font-weight:400">
                                        <span>{{date('j-M-Y', strtotime($order->created_at))}}</span>
                                    </div>
                                    <div class="col-md-2 col-sm-2" style="font-weight:400">
                                        <span>{{ ucfirst( $order->status ) }}</span>
                                    </div>
                                    <div class="col-md-2 col-sm-2" style="font-weight:400">
                                        <span>{{ ucfirst( App\Model\OrderType::select('name')->where('id', $order->order_type_id)->pluck('name')->first() ) }}</span>
                                    </div>
                                    <div class="col-md-4 col-sm-2" style="font-weight:400">
                                        <span>
                                            @foreach( $order['orderItems'] as $item)
                                                {{ $item->name.' x '.$item->quantity. ' ' }}
                                            @endforeach
                                        </span>
                                    </div>
                                    <div class="col-md-1 col-sm-2" style="font-weight:400">
                                        <span>{{$order->total_amount}}</span>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                            
                        </div>        
                    </div>
                </div>
                <div class="text-center">
                {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection