<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Label - Premium Responsive Bootstrap 4 Admin & Dashboard Template</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('vendors/iconfonts/mdi/css/materialdesignicons.css') }}">
  <!-- endinject -->
  <!-- vendor css for this page -->
  <!-- End vendor css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('css/shared/style.css') }}">
  <!-- endinject -->
  <!-- Layout style -->
  <link rel="stylesheet" href="{{ asset('css/demo_1/style.css') }}">
  <!-- Layout style -->
  <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="header-fixed">
  <div class="page-body">
    @include('layouts.header')

    @include('layouts.sidebarAdmin')


    <div class="page-content-wrapper">
      @yield('content')
    </div>
  </div>

  @include('layouts.scripts')

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('js')
</body>

</html>