@extends('layouts.master')

@section('content')

<!-- Header section
    ================================================== -->
    <!-- <section id="header" >
        <div class="container">
            <div class="row">
                @if (Auth::user() && (Auth::user()->billing_cycle==NULL || (Auth::user()->billing_cycle=='monthly' && (Auth::user()->food_preference=='' || Auth::user()->tiffin_quantity==''))))
                  <div class="alert alert-info">
                      <ul><strong><a href="{{ route('profile') }}">Click here to complete your profile by selecting your food preferences and address details.</a></strong><br></ul>
                  </div>
                @endif
                <div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10">
                    <div class="header-thumb">
                        <h1 class="wow fadeIn">Personalize Your Tiffin For This week</h1>
                        <h3 class="wow fadeInUp">Make Your Own Choice</h3>
                    </div>
                </div>

            </div>
        </div>
    </section> -->


<!-- Item section
    ================================================== -->
    <section id="portfolio">
        <div class="container body-content">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="iso-box col-md-6 col-sm-6">
                          <div class="portfolio-thumb">
                              <a href="{{ route('subscription', ['type'=>'lunch']) }}">
                              <img src="{{ asset('images/lunch1.jpg') }}" class="img-responsive" alt="Lunch">
                              <div class="portfolio-overlay">
                                  <div class="portfolio-item">
                                      <h2>Personalize</h2>
                                  </div>
                              </div>
                              </a>
                          </div>
                          <div id="custom-btn">
                              <a  href="{{ route('subscription', ['type'=>'lunch']) }}" class="btn btn-default">LUNCH</a>
                          </div>
                      </div>

                      <div class="iso-box col-md-6 col-sm-6">
                          <div class="portfolio-thumb">
                              <a href="{{ route('subscription', ['type'=>'dinner']) }}">
                              <img src="{{ asset('images/dinner.jpg') }}" class="img-responsive" alt="Dinner">
                              <div class="portfolio-overlay">
                                  <div class="portfolio-item">
                                      <h2>Personalize</h2>
                                  </div>
                              </div>
                              </a>
                          </div>
                          <div id="custom-btn">
                              <a href="{{ route('subscription', ['type'=>'dinner']) }}" class="btn btn-default">DINNER</a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </section>
  @endsection
