<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Sayur Mayur</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/frontend/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/frontend/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/frontend/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/frontend/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/frontend/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/frontend/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: eNno - v4.3.0
  * Template URL: https://bootstrapmade.com/enno-free-simple-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

@section('header')
    @include('partials.header')
@show

@section('home')
    @include('section.home')
@show

  <main id="main">

    @section('service')
        
    @show

    @section('about')
        @include('section.about')
    @show

    @section('counts')

    @show

    @section('services')
        @include('section.services')
    @show

    @section('portfolio')
        @include('section.portfolio')
    @show

    {{-- @section('tertimonials')
        @include('section.tertimonials')
    @show --}}

    @section('cta')
        
    @show

    @section('team')
        @include('section.team')
    @show

    {{-- @section('contact')
        @include('section.contact')
    @show --}}

  </main><!-- End #main -->

@section('footer')
    @include('partials.footer')
@show

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/frontend/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/frontend/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/frontend/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/frontend/vendor/php-email-form/validate.js"></script>
  <script src="assets/frontend/vendor/purecounter/purecounter.js"></script>
  <script src="assets/frontend/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/frontend/js/main.js"></script>

</body>

</html>