@extends('layouts.master')
@section('content')

<section id="web">
    <div class="container">
        <div class="row">


            <div class="col-md-3 col-sm-12 ">                        
                <ul class="ma-nav ">
                    <li id="account" class="md-12 sm-2 pf-padding-0 pf-margin-0">
                        <a href="{{ route('dashboard')}}">
                            <strong>Account Dashboard</strong>
                            <span>Get An Overview Of Your Account</span>
                        </a>
                    </li>
                    <li id="myorders" class="md-12 sm-2 ">
                        <a class="active" href="{{ route('orders')}}">
                            <strong>View My Orders</strong>
                            <span>Check Past Order Items</span>
                        </a>
                    </li>
                    <li id="profile" class="md-12 sm-2 ">
                        <a href="">
                            <strong>My Profile</strong>
                            <span>Your Name, Phone No., Password</span>
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
                <div class="order-header col-md-12 col-md-12">
                    <h1 class="wow">Your Orders</h1>
                    <h3 class="wow">Your Total Order Count till date is <b>{{count($orders)}}</b></h3>
                </div>
                <div class="oreder-content">
                    <div class="col-md-12 col-md-12">
                        <div class="col-md-1 col-sm-2">
                            <h4>ID</h4>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <h4>Date</h4>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <h4>Status</h4>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <h4>Type</h4>
                        </div>
                        <div class="col-md-4 col-sm-2">
                            <h4>Items</h4>
                        </div>
                        <div class="col-md-1 col-sm-2">
                            <h4>Amount</h4>
                        </div>
                    </div>
                            
                    @foreach($orders as $order)
                    <div class="col-md-12 col-md-12">
                        <div class="col-md-1 col-sm-2" style="font-weight:400">
                            <p>{{$order['orderId']}}</p>
                        </div>
                        <div class="col-md-2 col-sm-2" style="font-weight:400">
                            <p>{{date('j-M-Y', strtotime($order['date']))}}</p>
                        </div>
                        <div class="col-md-2 col-sm-2" style="font-weight:400">
                            <p>{{$order['status']}}</p>
                        </div>
                        <div class="col-md-2 col-sm-2" style="font-weight:400">
                            <p>{{$order['orderType']}}</p>
                        </div>
                        <div class="col-md-4 col-sm-2" style="font-weight:400">
                            <p>
                                @foreach( $order['items'] as $item)
                                    {{ $item.'  ' }}
                                @endforeach
                            </p>
                        </div>
                        <div class="col-md-1 col-sm-2" style="font-weight:400">
                            <p>{{$order['amount']}}</p>
                        </div>
                    </div>
                    @endforeach
                </div>        
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</section>

@endsection