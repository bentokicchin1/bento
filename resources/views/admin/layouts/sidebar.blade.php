  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>Alexander Pierce</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <ul class="sidebar-menu" data-widget="tree">
              <li class="">
                  <a href="{{ route('admin-user-list') }}">
                    <i class="fas fa-users"></i> <span>User Management</span>
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
                  <i class="fas fa-tasks"></i> <span>Menu Management</span>
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
                  <i class="fas fa-tasks"></i> <span>Order Management</span>
                  <span class="pull-right-container">
                    <!-- <i class="fas fa-angle-left pull-right"></i> -->
                  </span>
                </a>
                <!-- <ul class="treeview-menu">
                  <li><a href="{{ route('admin-menu-add') }}"><i class="fas fa-calendar-alt"></i> Weekly Menu</a></li>
                </ul> -->
              </li>
              <li class="">
                <a href="{{ route('admin-billpayment-list') }}">
                  <i class="fas fa-calendar"></i> <span>Bill Payments</span>
                  <span class="pull-right-container">
                    <!-- <i class="fas fa-angle-left pull-right"></i> -->
                  </span>
                </a>
                <!-- <ul class="treeview-menu">
                  <li><a href="{{ route('admin-order-list') }}"><i class="fas fa-sticky-note"></i> Orders</a></li>
                </ul> -->
              </li>
              <li class="treeview">
                  <a href="#">
                    <i class="fas fa-utensils"></i> <span>Dish Management</span>
                    <span class="pull-right-container">
                      <!-- <i class="fas fa-angle-left pull-right"></i> -->
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{ route('admin-dish-list') }}"><i class="fas fa-glass-martini"></i> Dish</a></li>
                    <li><a href="{{ route('admin-dish-type-list') }}"><i class="fas fa-utensil-spoon"></i> Dish Type</a></li>
                  </ul>
              </li>
              <li class="treeview">
                  <a href="#">
                    <i class="fas fa-map-marker"></i> <span>Location Management</span>
                    <span class="pull-right-container">
                      <!-- <i class="fas fa-angle-left pull-right"></i> -->
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{ route('admin-area-list') }}"><i class="fas fa-location-arrow"></i> Area</a></li>
                    <li><a href="{{ route('admin-location-list') }}"><i class="fas fa-building"></i> Location</a></li>
                  </ul>
              </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
