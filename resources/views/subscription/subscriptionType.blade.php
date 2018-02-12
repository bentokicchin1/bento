@extends('layouts.master')

@section('content')

<!-- Header section
    ================================================== -->
    <section id="header" >
        <div class="container">
            <div class="row">

                <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">
                    <div class="header-thumb">
                        <h1 class="wow fadeIn">Subscription Type</h1>
                        <h3 class="wow fadeInUp">Make Your Choice</h3>
                    </div>
                </div>

            </div>
        </div>
    </section>


<!-- Item section
    ================================================== -->
    <section id="portfolio">
        <div class="container body-content">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                <!-- <div class="portfolio-thumb">
                    <img src="{{ asset('images/lunch1.jpg') }}" class="img-responsive" alt="Lunch">
                </div> -->
                <div id="custom-btn">
                    <a  href="{{ route('subscription', ['type'=>'lunch']) }}" class="btn btn-default">LUNCH</a>
                </div>
            </div>

            <div class="col-md-6 col-sm-12">
                <!-- <div class="portfolio-thumb">
                    <img src="{{ asset('images/dinner.jpg') }}" class="img-responsive" alt="Dinner">
                </div> -->
                <div id="custom-btn">
                    <a href="{{ route('subscription', ['type'=>'dinner']) }}" class="btn btn-default">DINNER</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection