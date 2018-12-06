  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>{{Auth::user()->name}}</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <ul class="sidebar-menu" data-widget="tree" style="margin-top:30px;">
              <li class="">
                  <a href="{{ route('admin-dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
                      <!-- <i class="fas fa-angle-left pull-right"></i> -->
                    </span>
                  </a>
                  <!-- <ul class="treeview-menu">
                    <li><a href="{{ route('admin-user-list') }}"><i class="fas fa-user-secret"></i> Users</a></li>
                  </ul> -->
              </li>
              <li class="">
                  <a href="{{ route('admin-user-list') }}">
                    <i class="fa fa-users"></i> <span>User Management</span>
                    <span class="pull-right-container">
                      <!-- <i class="fas fa-angle-left pull-right"></i> -->
                    </span>
                  </a>
                  <!-- <ul class="treeview-menu">
                    <li><a href="{{ route('admin-user-list') }}"><i class="fas fa-user-secret"></i> Users</a></li>
                  </ul> -->
              </li>
              <li class="">
                <a href="{{ route('admin-menu-add') }}">
                  <i class="fa fa-calendar"></i> <span>Menu Management</span>
                  <span class="pull-right-container">
                    <!-- <i class="fas fa-angle-left pull-right"></i> -->
                  </span>
                </a>
                <!-- <ul class="treeview-menu">
                  <li><a href="{{ route('admin-menu-add') }}"><i class="fas fa-calendar-alt"></i> Weekly Menu</a></li>
                </ul> -->
              </li>
              <li class="">
                <a href="{{ route('admin-order-list') }}">
                  <i class="fa fa-bars"></i> <span>Order Management</span>
                  <span class="pull-right-container">
                    <!-- <i class="fas fa-angle-left pull-right"></i> -->
                  </span>
                </a>
                <!-- <ul class="treeview-menu">
                  <li><a href="{{ route('admin-menu-add') }}"><i class="fas fa-calendar-alt"></i> Weekly Menu</a></li>
                </ul> -->
              </li>
              <!-- <li class="">
                <a href="{{ route('admin-billpayment-list') }}">
                  <i class="fas fa-credit-card"></i> <span>Bill Payments</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li> -->
              <li class="treeview">
                  <a href="#">
                    <i class="fa fa-cutlery"></i> <span>Dish Management</span>
                    <span class="pull-right-container">
                      <!-- <i class="fas fa-angle-left pull-right"></i> -->
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{ route('admin-dish-list') }}"><i class="fa fa-glass"></i> Dish</a></li>
                    <li><a href="{{ route('admin-dish-type-list') }}"><i class="fa fa-spoon"></i> Dish Type</a></li>
                  </ul>
              </li>
              <li class="treeview">
                  <a href="#">
                    <i class="fa fa-map-marker"></i> <span>Location Management</span>
                    <span class="pull-right-container">
                      <!-- <i class="fas fa-angle-left pull-right"></i> -->
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{ route('admin-area-list') }}"><i class="fa fa-location-arrow"></i> Area</a></li>
                    <li><a href="{{ route('admin-location-list') }}"><i class="fa fa-hand-o-right"></i> Location</a></li>
                  </ul>
              </li>
              <li class="treeview">
                  <a href="admin-feedback-list">
                    <i class="fa fa-comments-o"></i> <span>Feedbacks</span>
                    <span class="pull-right-container">
                      <!-- <i class="fas fa-angle-left pull-right"></i> -->
                    </span>
                  </a>
              </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
