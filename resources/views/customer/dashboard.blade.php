@extends('layouts.master')
@section('content')

<section id="web">
    <div class="container">
        <div class="row">


            <div class="col-md-3 col-sm-12 ">                        
                <ul class="ma-nav ">
                    <li id="account" class="md-12 sm-2 pf-padding-0 pf-margin-0">
                        <a class="active" href="{{ route('dashboard')}}">
                            <strong>Account Dashboard</strong>
                            <span>Get An Overview Of Your Account</span>
                        </a>
                    </li>
                    <li id="myorders" class="md-12 sm-2 ">
                        <a href="https://www.pepperfry.com/customer/myorders">
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
                        <a href="https://www.pepperfry.com/customer/address_book">
                            <strong>My Address Book</strong>
                            <span>Add, Edit Addresses</span>
                        </a>
                    </li>
                </ul>                        
            </div>


            <div class="col-md-9 col-sm-12">
                
                <div class="tab-inner-content">
                    <p class="para">
                        Anil Gupta <br>
                        anilkumar.g@pepperfry.com<br>
                        9029710143</p>
                        <a class="pf-link ma-btn" href="">Edit Your Account Details</a>
                </div>

                <div class="ma-page-ttl-sec pf-margin-top20 pf-margin-bott10">
                    <div class="ma-page-ttl font-16 pf-semi-bold-text">Your Last 5 Orders</div>
                    <div class="ma-order-placed font-13">
                        You have placed <strong>102 orders </strong>        </div>
                </div>

                
                <div >
                    
                    <div class="col-md-2 col-sm-2 pf-col"><p>Order No.</p> <span class="pf-semi-bold-text">200010339</span></div>
                    <div class="col-md-2 col-sm-2 pf-col"><p>Date</p> <span class="pf-semi-bold-text">1st October 2017</span></div>
                    <div class="col-md-4 col-sm-4 pf-col"><p>Order Items</p> 
                        <ul class="ma-nav ">
                            <li><span>Bhendi x 1</span></li>
                            <li><span>Roti x 5</span></li>
                            <li><span>Rice x 1</span></li>
                            <li><span>Dal x 1</span></li>
                            <li><span>Butter Milk x 1</span></li>
                        </ul>
                    </div>
                    <div class="col-md-2 col-sm-2 pf-col"><p>Order Type.</p> <span class="pf-semi-bold-text">Dinner</span></div>
                    <div class="col-md-2 col-sm-2 pf-col"><p>Total Amount</p> <span class="pf-semi-bold-text">250</span></div>
                   
                    
                </div>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</section>

@endsection