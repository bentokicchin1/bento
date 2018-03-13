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
                        <a href="{{ route('orders')}}">
                            <strong>View My Orders</strong>
                            <span>Check Past Order Items</span>
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
                <div class="container-fluid">
                    <div class="row">

                        <div class="order-content col-md-12 col-sm-12">
                            <div class="heading">Manage Your Address</div>
                            @include('layouts.success')
                            @include('layouts.errors')
                            @foreach($addressList as $address)
                            <?php
                            if($address['default'] == 1){
                                $status = 'Default';
                            }else{
                                $status = '';
                            }
                            ?>
                            <div class="col-md-6 col-sm-12 address-box">
                                <div class='address-name'> {{ $address['name'] }} </div>
                                <div class='edit-delete'><a href="{{ route('address-edit',['id' => $address['id']]) }}">Edit</a>/<a onclick="return confirm('Are you sure you want to delete?')" href="{{ route('address-delete', ['id' => $address['id']]) }}">Delete</a></div>
                                <div class="address-location">{{ $address['location'].', '.$address['area_location']['name'].', '.$address['area']['name'].', '.$address['city']['name'].', '.$address['state'].', '.$address['pincode']}} </div>
                                <div class="address-type">{{ $address['address_type'] }}</div>
                                @if ($status)
                                <div class="default-address" style="float:right">{{ $status }}</div>
                                @endif
                            </div>
                            @endforeach
                            <div class="col-md-6 col-sm-12" style="margin-bottom:20px">
                                <label class="address-new"><a href="{{ route('address-add')}}">Add New Address</a></label>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
