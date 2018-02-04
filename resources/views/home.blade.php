@extends('layouts.master')

@section('content')

<!-- Header section
    ================================================== -->
    <section id="header" >
        <div class="container">
            <div class="row">

                <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">
                    <div class="header-thumb">
                        <h1 class="wow fadeIn">Food With Difference</h1>
                        <h3 class="wow fadeInUp" data-wow-delay="0.7s">Make Your Choice</h3>
                    </div>
                </div>

            </div>
        </div>
    </section>


<!-- Item section
    ================================================== -->
    <section id="portfolio">
        <div class="container">
            <div class="row">

                <div class="col-md-12 col-sm-12">

                    <!-- iso section -->
                    <div class="iso-section wow fadeInUp" data-wow-delay="0s">
                        <!-- <h1>Choose Your Food</h1> -->

                        <!-- iso box section -->
                        <div class="iso-box-section wow fadeInUp" data-wow-delay="0.2s">
                            <div class="iso-box-wrapper col4-iso-box">

                                <div class="iso-box photoshop branding col-md-4 col-sm-6">
                                    <div class="portfolio-thumb">
                                        <img src="{{ asset('images/breakfast.jpg') }}" class="img-responsive" alt="Breakfast">
                                        <div class="portfolio-overlay">
                                            <div class="portfolio-item">
                                                <a href="{{ route('order', ['type'=>'breakfast']) }}">
                                                <h2>Order Now</h2>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div id="custom-btn">
                                    <a  href="{{ route('order', ['type'=>'breakfast']) }}" class="btn btn-default">BREAKFAST</a>
                                </div>
                            </div>

                            <div class="iso-box graphic template col-md-4 col-sm-6">
                                <div class="portfolio-thumb">
                                    <img src="{{ asset('images/lunch1.jpg') }}" class="img-responsive" alt="Lunch">
                                    <div class="portfolio-overlay">
                                        <div class="portfolio-item">
                                            <a href="{{ route('order', ['type'=>'lunch']) }}">
                                                <h2>Order Now</h2>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div id="custom-btn">
                                    <a  href="{{ route('order', ['type'=>'lunch']) }}" class="btn btn-default">LUNCH</a>
                                </div>
                            </div>

                            <div class="iso-box template graphic col-md-4 col-sm-6">
                                <div class="portfolio-thumb">
                                    <img src="{{ asset('images/dinner.jpg') }}" class="img-responsive" alt="Dinner">
                                    <div class="portfolio-overlay">
                                        <div class="portfolio-item">
                                            <a href="{{ route('order', ['type'=>'dinner']) }}">
                                                <h2>Order Now</h2>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div id="custom-btn">
                                    <a href="{{ route('order', ['type'=>'dinner']) }}" class="btn btn-default">DINNER</a>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</section>

@endsection