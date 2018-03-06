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
              <li class="active treeview">
                  <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Dish Master</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="active"><a href="{{ route('admin-dish-list') }}"><i class="fa fa-circle-o"></i> Dish</a></li>
                    <li class="active"><a href="{{ route('admin-dish-type-list') }}"><i class="fa fa-circle-o"></i> Dish Type</a></li>
                  </ul>
              </li>
              <li class="active treeview">
                  <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Locations</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="active"><a href="{{ route('city-list') }}"><i class="fa fa-circle-o"></i> City</a></li>
                    <li class="active"><a href="{{ route('sector-list') }}"><i class="fa fa-circle-o"></i> Sectors</a></li>
                  </ul>
              </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
