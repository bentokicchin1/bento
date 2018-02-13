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
                        <a class="active" href="{{route('profile')}}">
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
                <div class="container-fluid">
                    <div class="row">
                      <div class="col-sm">
                        One of three columns
                      </div>
                      <div class="col-sm">
                        One of three columns
                      </div>
                      <div class="col-sm">
                        One of three columns
                      </div>
                    </div>
                  </div> 
            
            </div>
    </div>
</section>

@endsection