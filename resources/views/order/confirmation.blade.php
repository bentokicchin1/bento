@extends('layouts.master')

@section('content')
<!-- Header section
    ================================================== -->
<section id="header-custom">
    <div class="container bottom-line">
        <div class="row">
            <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">
                <div class="header-thumb">
                    <h1 class="wow">ORDER PLACED SUCCESSFULLY</h1>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Book Now section
================================================== -->
<section id="order">
    <div class="container body-content">
        <div class="row">
            <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8 order wow fadeIn" data-wow-delay="0s">
                    <div class="big-message">Your order ID is 1234. You will receive an order confirmation email.</div>
            </div>
        </div>
    </div>
</section>

@endsection
