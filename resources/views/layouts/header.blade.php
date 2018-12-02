<!-- Navigation section
  ================================================== -->
  <div class="nav-container">
    <nav class="nav-inner transparent">
      <div class="navbar">
        <div class="container">
          <!-- <div class="row"> -->
          <div class="brand">
              <!-- <a  href="/"><img src="images/logo/2/2.png" style="height:80px;"/></a> -->
              <a  href="/">Bento</a>
          </div>
          <div class="navicon">
              <div class="menu-container">
                <div class="circle dark inline">
                  <i class="icon ion-navicon"></i>
                </div>
                <div class="list-menu">
                  <i class="icon ion-close-round close-iframe"></i>
                  <div class="intro-inner">
                    <ul id="nav-menu">
                       @guest
                       <li><a href="{{ route('login') }}">Login</a></li>
                       <li><a href="{{ route('register') }}">Register</a></li>
                       <li><a href="{{ route('contact-us') }}">Contact-Us</a></li>
                       @else
                         <li><a href="{{ route('profile') }}">My Account</a></li>
                         <li><a href="{{ route('orders') }}">My Orders</a></li>
                         @if(Auth::user()->billing_cycle=='daily')
                            <li ><a href="{{ route('home') }}">Order Now</a></li>
                         @else
                            <li><a href="{{ route('home') }}">Personalize Your Order</a></li>
                         @endif
                       <li><a href="{{ route('feedback') }}">Feedback</a></li>
                       <li>
                          <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                              {{ csrf_field() }}
                          </form>
                        </li>
                        <li><a href="{{ route('contact-us') }}">Contact-Us</a></li>
                    @endguest
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </div>
  <!-- Header section
  ================================================== -->
  <section id="header" >
      <div class="container">
          <div class="row">
              @include('layouts.errors')
              @if (Auth::user() && (Auth::user()->billing_cycle==NULL || (Auth::user()->billing_cycle=='monthly' && (Auth::user()->food_preference=='' || Auth::user()->tiffin_quantity==''))))
                <div class="alert alert-info">
                    <ul><strong><a href="{{ route('profile') }}">Click here to complete your profile by selecting your food preferences and address details.</a></strong><br></ul>
                </div>
              @endif
              @if(route('home') == Request::url())
                <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">
                    <div class="header-thumb">
                        <h1 class="wow fadeIn">Food With Difference</h1>
                        <h3 class="wow fadeInUp" data-wow-delay="0.3s">Make Your Own Choice</h3>
                    </div>
                </div>
              @endif
          </div>
      </div>
  </section>
