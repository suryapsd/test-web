<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('assets') }}/" data-template="vertical-menu-template">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ $title }} | Bali Lyfe Ventures</title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />

    <!-- Fonts -->
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" /> --}}

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />

    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
  </head>

  <body>
    <!-- Content -->
    @yield('content')
    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <!-- endbuild -->

    <!-- Page JS -->
    <script src="{{ asset('assets/js/pages-auth.js') }}"></script>

    <script>
      $(document).ready(function() {
        $('#togglePassword').click(function() {
          const passwordField = $('#password');
          const fieldType = passwordField.attr('type') === 'password' ? 'text' : 'password';
          passwordField.attr('type', fieldType);

          // Ubah ikon mata sesuai dengan tipe input
          $(this).find('i').toggleClass('ti-eye-off ti-eye');
        });
        $('#confirmPassword').click(function() {
          const passwordField = $('#password_confirmation');
          const fieldType = passwordField.attr('type') === 'password' ? 'text' : 'password';
          passwordField.attr('type', fieldType);

          // Ubah ikon mata sesuai dengan tipe input
          $(this).find('i').toggleClass('ti-eye-off ti-eye');
        });

      });

      function loaderBtn(idForm, idBtn) {
        const submitBtn = $('#' + idBtn);
        submitBtn.prop('disabled', true);
        submitBtn.find('.spinner_submit').removeClass('d-none');
        submitBtn.find('.arrow_next').addClass('d-none');

        setTimeout(function() {
          submitBtn.prop('disabled', false);
          submitBtn.find('.spinner_submit').addClass('d-none');
          submitBtn.find('.arrow_next').removeClass('d-none');
        }, 4000);
      }
    </script>

    @stack('script')
  </body>

</html>
