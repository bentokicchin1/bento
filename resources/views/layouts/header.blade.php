<!-- Preloader section
  ================================================== -->
<!--   <div class="preloader">

    <div class="sk-spinner sk-spinner-pulse"></div>

</div> -->

<!-- Navigation section
  ================================================== -->
  <div class="nav-container">
    <nav class="nav-inner transparent">

      <div class="navbar">
        <div class="container">
          <!-- <div class="row"> -->

            <div class="brand">
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
                       <li><a href="{{ route('login') }}">My Order</a></li>
                       <li ><a href="{{ route('dashboard') }}">Profile</a></li>
                       <li><a href="{{ route('login') }}">Subscription</a></li>
                       <li>
                          <a href="{{ route('logout') }}"
                          onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
                          Logout
                      </a>

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

<!-- </div> -->
</div>
</div>

</nav>
</div>