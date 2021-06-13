<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>GoSearchClient</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/workers/assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/workers/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('assets/workers/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/workers/assets/vendor/icofont/icofont.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/workers/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/workers/assets/vendor/owl.carousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/workers/assets/vendor/venobox/venobox.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/workers/assets/vendor/aos/aos.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/workers/assets/css/style.css') }}" rel="stylesheet">
  <!-- Custom styles for this page -->
  <link href="{{ asset('assets/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- =======================================================
  * Template Name: BizLand - v1.2.1
  * Template URL: https://bootstrapmade.com/bizland-bootstrap-business-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Top Bar ======= -->
  <div id="topbar" class="d-none d-lg-flex align-items-center fixed-top">
    <div class="container d-flex">
      
    </div>
  </div>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo mr-auto"><a href="{{ url('researcher') }}">GoSearch<span>Client</span></a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo mr-auto"><img src="assets/img/logo.png" alt=""></a>-->

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li class="{{ request()->is('inqurier') ? 'active' : ''}}"><a href="{{ url('inqurier') }}">How We Work</a></li>
          <li class="{{ request()->is('inqurier/inquiries') ? 'active' : ''}}"><a href="{{ url('inqurier/inquiries') }}">Inquiries</a></li>
          <li class="{{ request()->is('inqurier/companies') ? 'active' : ''}}"><a href="{{ url('inqurier/companies') }}">Companies</a></li>
          <li class="{{ request()->is('inqurier/faq') ? 'active' : ''}}"><a href="{{ url('inqurier/faq') }}">FAQ</a></li>
          <li class="{{ request()->is('inqurier/notice') ? 'active' : ''}}"><a href="{{ url('inqurier/notice') }}">Notice</a></li>
          <li class="{{ request()->is('inqurier/my-work') ? 'active' : ''}}"><a href="{{ url('inqurier/my-work') }}">My Work</a></li>
          <li class="{{ request()->is('inqurier/payments') ? 'active' : ''}}"><a href="{{ url('inqurier/payments') }}">Payments</a></li>
          <li class="drop-down"><a href="">Account</a>
            <ul>
              <li><a href="{{ url('inqurier/profile') }}">Profile</a></li>
              <li><a href="{{ url('logout') }}">Logout</a></li>
            </ul>
          </li>


        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->
    @yield('content')

    @include('workers.inqurier.layout.footer')