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
                        <a href="{{ route('orders')}}">
                            <strong>View My Orders</strong>
                            <span>Check Past Order Items</span>
                        </a>
                    </li>
                    <li id="profile" class="md-12 sm-2 ">
                        <a href="https://www.pepperfry.com/customer/account">
                            <strong>My Profile</strong>
                            <span>Your Name, Phone No., Password</span>
                        </a>
                    </li>
                    <li id="address" class="md-12 sm-2 ">
                        <a class="active" href="{{route('address')}}">
                            <strong>My Address Book</strong>
                            <span>Add, Edit Addresses</span>
                        </a>
                    </li>
                </ul>                        
            </div>


            <div class="col-md-9 col-sm-12">                
                <div class="order-header col-md-12 col-md-12">
                    <h1 class="wow">Your Address List</h1>
                    {{--  <h3 class="wow">Your Total Order Count till date is </h3>  --}}
                </div>
                <div class="oreder-content">
                    @foreach($addressList as $address)
                    <?php
                    if($address['default'] == 1){
                        $status = 'Default';
                    }else{
                        $status = '';
                    }
                    ?>
                    <div class="col-md-6 col-sm-6" style="margin-bottom:20px">
    
                        <div class='address-name'> {{ $address['name'] }} </div>
                        <div class="address-location">{{ $address['location'].', '.$address['area'].', '.$address['city'].', '.$address['state'].', '.$address['pincode']}} </div>
                        {{--  <div class="types">  --}}
                        <div class="address-type">{{ $address['address_type'] }}</div>
                        @if ($status)
                        <div class="default-address" style="float:right">{{ $status }}</div>
                        @endif
                    {{--  </div>                        --}}
                    </div>
                    @endforeach
                    <div class="col-md-4 col-sm-4" style="margin-bottom:20px">                               
                        <label class="address-new"><a href="{{ route('address-add')}}">Add New Address</a></label>
                    </div>       
                    
                </div>        
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</section>

@endsection