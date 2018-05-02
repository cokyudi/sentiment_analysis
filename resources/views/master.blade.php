<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="url" content="{{URL('')}}">
  <title>@yield('title')</title>
  <link rel="shortcut icon" href="{{URL('public/favicon.ico')}}" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{URL('public/template')}}/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{URL('public/template')}}/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{URL('public/template')}}/bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{URL('public/template')}}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{URL('public/template')}}/plugins/sweetalert2/sweetalert2.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{URL('public/template')}}/bower_components/select2/dist/css/select2.min.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{URL('public/template')}}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{URL('public/template')}}/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{URL('public/template')}}/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{URL('public/template')}}/dist/css/skins/skin-red.min.css">
  <!-- Costum styling -->
  <link rel="stylesheet" href="{{URL('public')}}/css/style.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="{{URL('public')}}/css/fonts.css">
</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>P</b>RO</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>PRO</b>DENPASAR</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="{{URL('logout')}}">Keluar</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{URL('public/template')}}/dist/img/avatar5.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{session()->get('admin')['nama']}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li id="menu-dashboard">
          <a href="{{URL('dashboard')}}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li id="menu-pengaduan">
          <a href="{{URL('pengaduan')}}">
            <i class="fa fa-exclamation-triangle"></i> <span>Pengaduan</span>
          </a>
        </li>
        <li id="menu-laporan">
          <a href="{{URL('laporan')}}">
            <i class="fa fa-bar-chart"></i> <span>Laporan</span>
          </a>
        </li>
        @if(session()->get('admin')['level'] == 1)
        <li id="menu-komentar">
          <a href="{{URL('komentar')}}">
            <i class="fa fa-commenting"></i> <span>Komentar</span>
          </a>
        </li>
        <li id="menu-admin">
          <a href="{{URL('admin')}}">
            <i class="fa fa-user"></i> <span>Admin</span>
          </a>
        </li>
        <li id="menu-pengetahuan">
          <a href="{{URL('pengetahuan')}}">
            <i class="fa fa-database"></i> <span>Tabel Pengetahuan</span>
          </a>
        </li>
        <li id="menu-stopword">
          <a href="{{URL('stopword')}}">
            <i class="fa fa-database"></i> <span>Tabel Stopword</span>
          </a>
        </li>
        <li id="menu-kamus">
          <a href="{{URL('kamus')}}">
            <i class="fa fa-database"></i> <span>Tabel Kamus</span>
          </a>
        </li>
        <li id="menu-training">
          <a href="{{URL('training')}}">
            <i class="fa fa-book"></i> <span>Training</span>
          </a>
        </li>
        <li id="menu-testing">
          <a href="{{URL('testing')}}">
            <i class="fa fa-play-circle"></i> <span>Testing</span>
          </a>
        </li>
        <li id="menu-evaluasi">
          <a href="{{URL('evaluasi')}}">
            <i class="fa fa-check"></i> <span>Evaluasi</span>
          </a>
        </li>
        <!-- <li id="menu-setting">
          <a href="{{URL('setting')}}">
            <i class="fa fa-gears"></i> <span>Pengaturan</span>
          </a>
        </li> -->
        @endif
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>@yield('header')</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; Cok Agung Yudi 2018</strong> All rights
    reserved.
  </footer>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{URL('public/template')}}/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{URL('public/template')}}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="{{URL('public/template')}}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{URL('public/template')}}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src=".{{URL('public/template')}}/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="{{URL('public/template')}}/bower_components/fastclick/lib/fastclick.js"></script>
<!-- jQuery Validation -->
<script src="{{URL('public/template')}}/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="{{URL('public/template')}}/plugins/jquery-validation/dist/localization/messages_id.js"></script>
<!-- SweetAlert2 -->
<script src="{{URL('public/template')}}/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Chartjs -->
<script src="{{URL('public/template')}}/plugins/chartjs/chart.bundle.js"></script>
<!-- Select2 -->
<script src="{{URL('public/template')}}/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- bootstrap datepicker -->
<script src="{{URL('public/template')}}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- date-range-picker -->
<script src="{{URL('public/template')}}/bower_components/moment/min/moment.min.js"></script>
<script src="{{URL('public/template')}}/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- AdminLTE App -->
<script src="{{URL('public/template')}}/dist/js/adminlte.min.js"></script>
<!-- Page Script -->
@yield('script')
</body>
</html>
