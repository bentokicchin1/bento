@extends('layouts.master')

@section('content')

<!-- Header section
    ================================================== -->
    <section id="header" >
        <div class="container">
            <div class="row">
                @include('layouts.errors')
                <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">
                    <div class="header-thumb">
                        <h1 class="wow fadeIn">Food With Difference</h1>
                        <h3 class="wow fadeInUp" data-wow-delay="0.3s">Make Your Own Choice</h3>
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
                <div class="col-md-12 col-sm-12">

                    <div class="iso-box col-md-6 col-sm-6">
                        <div class="portfolio-thumb">
                            <a href="{{ route('order', ['type'=>'lunch']) }}">
                            <img src="{{ asset('images/lunch-new-1.jpg') }}" class="img-responsive" alt="Lunch">
                            <div class="portfolio-overlay">
                                <div class="portfolio-item">
                                    <h2>Order Now</h2>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div id="custom-btn">
                            <a  href="{{ route('order', ['type'=>'lunch']) }}" class="btn btn-default">LUNCH</a>
                        </div>
                    </div>

                    <div class="iso-box col-md-6 col-sm-6">
                        <div class="portfolio-thumb">
                            <a href="{{ route('order', ['type'=>'dinner']) }}">
                            <img src="{{ asset('images/dinner-new-1.jpg') }}" class="img-responsive" alt="Dinner">
                            <div class="portfolio-overlay">
                                <div class="portfolio-item">
                                    <h2>Order Now</h2>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div id="custom-btn">
                            <a href="{{ route('order', ['type'=>'dinner']) }}" class="btn btn-default">DINNER</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection
