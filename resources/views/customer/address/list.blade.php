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
                              <div class="col-md-6 col-sm-12 address-box">
                                  <div class='address-name'> {{ $address['name'] }} </div>
                                  <div class='edit-delete'><a href="{{ route('address-edit',['id' => $address['id']]) }}">Edit</a>/<a onclick="return confirm('Are you sure you want to delete?')" href="{{ route('address-delete', ['id' => $address['id']]) }}">Delete</a></div>
                                  <div class="address-location">{{ $address['location'].', '.$address['area_location']['name'].', '.$address['area_data']['name'].', '.$address['city_data']['name'].', '.$address['state'].', '.$address['pincode']}} </div>
                                  <div class="address-type">{{ ucfirst($address['order_type']['name']) }}</div>
                              </div>
                            @endforeach
                            <div class="col-md-6 col-sm-12" style="margin-bottom:20px">
                                <a href="{{ route('address-add')}}"><label class="address-new">Add New Address</label></a>
                            </div>
                          </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
