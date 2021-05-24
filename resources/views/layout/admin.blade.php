<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Electronic Voting System | EVS</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Page specific style sheet -->
  @yield('stylesheets')

  <!-- Toastr -->
  @toastr_css
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('logout') }}" class="nav-link"><small>LOGOUT</small></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="EVS Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><small>Electronic Voting System</small></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ !empty(Helper::get_user_image()) ? url('storage/image/'.Helper::get_user_image()->hash_name) : asset('dist/img/default-user.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-header">MAIN NAVIGATION</li>

          <li class="nav-item">
            <a href="/" class="nav-link {{ Request::is('admin/homepage') ? "active" : "" }}">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Overview
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('election_result') }}" class="nav-link {{ Request::is('election-result') ? "active" : "" }}">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Results
              </p>
            </a>
          </li>

          <li class="nav-item {{ Request::is('elections/create') || Request::is('elections') ? "menu-open" : "" }}">
            <a href="#" class="nav-link {{ Request::is('elections/create') || Request::is('elections') ? "active" : "" }}">
              <i class="nav-icon fas fa-poll-h"></i>
              <p>
                Elections
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('elections.create') }}" class="nav-link {{ Request::is('elections/create') ? "active" : "" }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('elections.index') }}" class="nav-link {{ Request::is('elections') ? "active" : "" }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{ route('candidates.index') }}" class="nav-link {{ Request::is('candidates') ? "active" : "" }}">
              <i class="nav-icon fas fa-address-card"></i>
              <p>
                Candidates
              </p>
            </a>
          </li>

          <li class="nav-item {{ Request::is('teachers/create') || Request::is('teachers') ? "menu-open" : "" }}">
            <a href="#" class="nav-link {{ Request::is('teachers/create') || Request::is('teachers') ? "active" : "" }}">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>
                Teachers
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('teachers.create') }}" class="nav-link {{ Request::is('teachers/create') ? "active" : "" }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Import New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('teachers.index') }}" class="nav-link {{ Request::is('teachers') ? "active" : "" }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{ route('students_list') }}" class="nav-link {{ Request::is('students-list') ? "active" : "" }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Students
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('courses.index') }}" class="nav-link {{ Request::is('courses') ? "active" : "" }}">
              <i class="nav-icon fas fa-bullseye"></i>
              <p>
                Courses
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2021 <a href="/">Electronic Voting System | EVS</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- Page specific script -->
@yield('scripts')

<!-- Toastr -->
@toastr_js
@toastr_render
</body>
</html>
