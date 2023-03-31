 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/widgets.html" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Widgets
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item {{(Request::routeIs('admin.twod_type.index') || Request::routeIs('admin.twod_section.index') || Request::routeIs('admin.twod_schedule.index')) ? 'menu-open' : ''}}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                2D Sections
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.twod_type.index')}}" class="nav-link {{Request::routeIs('admin.twod_type.index') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Types</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.twod_schedule.index')}}" class="nav-link {{Request::routeIs('admin.twod_schedule.index') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Schedules</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.twod_section.index')}}" class="nav-link {{Request::routeIs('admin.twod_section.index') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sections</p>
                </a>
              </li>
            </ul>
          </li>
           <li class="nav-item {{(Request::routeIs('admin.threed_section.index') || Request::routeIs('admin.threed_schedule.index') || Request::routeIs('admin.twod_schedule.index')) ? 'menu-open' : ''}}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                3D Sections
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.threed_schedule.index')}}" class="nav-link {{Request::routeIs('admin.threed_schedule.index') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Schedules</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.threed_section.index')}}" class="nav-link {{Request::routeIs('admin.threed_section.index') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sections</p>
                </a>
              </li>
            </ul>
          </li>
          {{-- <li class="nav-item">
            <a href="{{route('admin.agent.index')}}" class="nav-link {{Request::routeIs('admin.agent.index') ? 'active' : ''}}">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Agent
              </p>
            </a>
          </li> --}}
          <li class="nav-item">
            <a href="{{route('admin.service.index')}}" class="nav-link {{Request::routeIs('admin.service.index') ? 'active' : ''}}">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Service
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.slide.index')}}" class="nav-link {{Request::routeIs('admin.slide.index') ? 'active' : ''}}">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Slides
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.closing-day.index')}}" class="nav-link {{Request::routeIs('admin.closing-day.index') ? 'active' : ''}}">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Closing Days
              </p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>