@extends('layouts.master')
@section('content')

<section id="web">
    <div class="container">
        <div class="row">



            <div class="md-3 sm-12 pf-col ma-left-sec">                        
                <ul class="row ma-nav pf-margin-0 pf-padding-0">
                    <li id="account" class="md-12 sm-2 pf-col pf-margin-0 pf-padding-0">
                        <a class="active" href="https://www.pepperfry.com/customer/dashboard">
                            <strong>Account Dashboard</strong>
                            <span>Get An Overview Of Your Account</span>
                        </a>
                    </li>
                    <li id="myorders" class="md-12 sm-2 pf-col pf-margin-0 pf-padding-0">
                        <a href="https://www.pepperfry.com/customer/myorders">
                            <strong>View My Orders</strong>
                            <span>Check Shipping Status, Re-Order Items</span>
                        </a>
                    </li>
                    <li id="wishlist" class="md-12 sm-2 pf-col pf-margin-0 pf-padding-0">
                        <a href="https://www.pepperfry.com/customer/wishlist">
                            <strong>My Wishlist</strong>
                            <span>Add Item To Cart, Remove Items, Add Notes</span>
                        </a>
                    </li>
                    <li id="profile" class="md-12 sm-2 pf-col pf-margin-0 pf-padding-0">
                        <a href="https://www.pepperfry.com/customer/account">
                            <strong>My Profile</strong>
                            <span>Your Name, Phone No., Password</span>
                        </a>
                    </li>
                    <li id="address" class="md-12 sm-2 pf-col pf-margin-0 pf-padding-0">
                        <a href="https://www.pepperfry.com/customer/address_book">
                            <strong>My Address Book</strong>
                            <span>Add, Edit Addresses</span>
                        </a>
                    </li>
                    <li id="myaccountNotification" class="md-12 sm-2 pf-col pf-margin-0 pf-padding-0">
                        <a href="https://www.pepperfry.com/customer/notification">
                            <strong>My Notifications</strong>
                            <span>View Delivery And Offer Messages</span>
                        </a>
                    </li>
                </ul>                        
            </div>


            <div class="md-9 sm-12 pf-col ma-right-sec">
                <div style="display: block;" class="tab-container" tab-show="accountdashboard">
                    <div class="tab-inner-content">
                        <p class="para">
                            Anil Gupta <br>
                            anilkumar.g@pepperfry.com<br>
                            0902971014                        </p>
                            <a class="pf-link ma-btn" href="https://www.pepperfry.com/customer/account">Edit Your Account Details</a>
                        </div>
                        <div class="ma-page-ttl-sec pf-margin-top20 pf-margin-bott10">
                            <div class="ma-page-ttl font-16 pf-semi-bold-text">Your Last 5 Orders</div>
                            <div class="ma-order-placed font-13">
                                You have placed <strong>89 orders </strong>        </div>
                            </div>


                            <div class="tab-inner-content">
                                <div class="ma-tab-li row">
                                    <div class="tab-li-ttl md-6 sm-6 pf-col">
                                        <div class="tab-li-ttl">Order Cancelled</div>    
                                    </div>
                                    <a class="green-btn md-6 sm-6 pf-col" href="javascript:void(0)" onclick="location.href = 'https://www.pepperfry.com/customer_account/reorder/4533792'">ORDER AGAIN</a>
                                </div>    
                                <div class="ma-tab-li row pf-margin-20">
                                    <div class="md-2 sm-2 pf-col"><p>Order No.</p> <span class="pf-semi-bold-text">303725354</span></div>
                                    <div class="md-3 sm-3 pf-col"><p>17th January 2018 <br>10:08:30 IST</p></div>
                                    <div class="md-3 sm-3 pf-col"><a data-modal="order-address_4533792" class="pf-link pf-underline" href="javascript:;">Click Here To View Address</a></div>
                                    <div class="md-4 sm-4 pf-col">Total Paid <span class="pf-semi-bold-text">Rs.898</span>

                                    </div>
                                </div>
                                <div class="ma-tab-li row pf-margin-20">
                                    <div class="md-2 sm-2 pf-col"><a href="https://www.pepperfry.com/yellow-plastic-and-acrylic-5-x-4-x-2-inch-hawa-mahal-chrome-alarm-clock-by-the-el-1614690.html" class="order-product" target="_blank">
                                        <img src="https://ii1.pepperfry.com/media/catalog/product/y/e/60x66/yellow-plastic-and-acrylic-5-x-4-x-2-inch-hawa-mahal-chrome-alarm-clock-by-the-elephant-company-yell-m5wsyk.jpg"></a></div>
                                        <div class="md-3 sm-3 pf-col"><a href="https://www.pepperfry.com/yellow-plastic-and-acrylic-5-x-4-x-2-inch-hawa-mahal-chrome-alarm-clock-by-the-el-1614690.html" class="order-product" target="_blank">Yellow Plastic and Acrylic 5 x 4 x 2 Inch Hawa Mahal Chrome Alarm Clock by The Elephant Company</a>
                                        </div>
                                        <div class="md-3 sm-3 pf-col">
                                            <p><span class="pf-semi-bold-text">SKU:</span> DE1614690-S-PM4200</p>
                                            <p><span class="pf-semi-bold-text">QTY: </span> 1</p>
                                            <p><span class="pf-semi-bold-text">CANCELLED ON:</span> 17th Jan 2018 </p>
                                        </div>
                                        <div class="md-4 sm-4 pf-col"><strong class="pf-block"></strong>
                                            <a class="pf-disabled" href="javascript:;" data-tooltip="Does Not Qualify">Return This Item</a><br>
                                        </div>
                                    </div>
                                </div>


                                <div class="tab-inner-content">
                                    <div class="ma-tab-li row">
                                        <div class="tab-li-ttl md-6 sm-6 pf-col">
                                            <div class="tab-li-ttl">Order Cancelled</div>    
                                        </div>
                                        <a class="green-btn md-6 sm-6 pf-col" href="javascript:void(0)" onclick="location.href = 'https://www.pepperfry.com/customer_account/reorder/4533792'">ORDER AGAIN</a>
                                    </div>    
                                    <div class="ma-tab-li row pf-margin-20">
                                        <div class="md-2 sm-2 pf-col"><p>Order No.</p> <span class="pf-semi-bold-text">303725354</span></div>
                                        <div class="md-3 sm-3 pf-col"><p>17th January 2018 <br>10:08:30 IST</p></div>
                                        <div class="md-3 sm-3 pf-col"><a data-modal="order-address_4533792" class="pf-link pf-underline" href="javascript:;">Click Here To View Address</a></div>
                                        <div class="md-4 sm-4 pf-col">Total Paid <span class="pf-semi-bold-text">Rs.898</span>

                                        </div>
                                    </div>
                                    <div class="ma-tab-li row pf-margin-20">
                                        <div class="md-2 sm-2 pf-col"><a href="https://www.pepperfry.com/yellow-plastic-and-acrylic-5-x-4-x-2-inch-hawa-mahal-chrome-alarm-clock-by-the-el-1614690.html" class="order-product" target="_blank">
                                            <img src="https://ii1.pepperfry.com/media/catalog/product/y/e/60x66/yellow-plastic-and-acrylic-5-x-4-x-2-inch-hawa-mahal-chrome-alarm-clock-by-the-elephant-company-yell-m5wsyk.jpg"></a></div>
                                            <div class="md-3 sm-3 pf-col"><a href="https://www.pepperfry.com/yellow-plastic-and-acrylic-5-x-4-x-2-inch-hawa-mahal-chrome-alarm-clock-by-the-el-1614690.html" class="order-product" target="_blank">Yellow Plastic and Acrylic 5 x 4 x 2 Inch Hawa Mahal Chrome Alarm Clock by The Elephant Company</a>
                                            </div>
                                            <div class="md-3 sm-3 pf-col">
                                                <p><span class="pf-semi-bold-text">SKU:</span> DE1614690-S-PM4200</p>
                                                <p><span class="pf-semi-bold-text">QTY: </span> 1</p>
                                                <p><span class="pf-semi-bold-text">CANCELLED ON:</span> 17th Jan 2018 </p>
                                            </div>
                                            <div class="md-4 sm-4 pf-col"><strong class="pf-block"></strong>
                                                <a class="pf-disabled" href="javascript:;" data-tooltip="Does Not Qualify">Return This Item</a><br>
                                            </div>
                                        </div>
                                    </div>

                                
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </section>

            @endsection