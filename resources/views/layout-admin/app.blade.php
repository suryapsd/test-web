<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('assets') }}/" data-template="vertical-menu-template">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ $title ?? 'CMS' }} | Layanan</title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    {{-- <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" /> --}}
    {{-- <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}"> --}}

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    @yield('vendor-style')

    <!-- Page CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}" /> --}}
    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    {{-- <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script> --}}
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    @stack('script-head')
  </head>

  <body>
    <style>
      /* .ck-balloon-panel {
        z-index: 99999 !important;
      } */

      :root {
        --ck-z-default: 100;
        --ck-z-modal: calc(var(--ck-z-default) + 999);
      }
    </style>
    <!-- Page Loader -->
    <style>
      /* Loader */
      .loader-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(255, 255, 255, 0.7);
        z-index: 10000 !important;
        display: flex;
        justify-content: center;
        align-items: center;
      }

      /* .select2-container {
        z-index: 9999 !important;
        position: relative;
      } */

      .select2-container--default .zindex9999 {
        z-index: 999999 !important;
      }
    </style>
    <style>
      /* Input */
      input[readonly] {
        background-color: #f2f2f2;
        color: #888;
        cursor: not-allowed;
      }

      /* Select2 container when readonly */
      .select2-readonly {
        background-color: #f2f2f2 !important;
        color: #888 !important;
        cursor: not-allowed !important;
        pointer-events: none;
      }

      /* Textarea */
      /* textarea[readonly] {
        background-color: #f2f2f2;
        color: #888;
        cursor: not-allowed;
      } */
    </style>
    <div id="page-loader" class="loader-container" style="display: {{ isset($hideLoader) ? 'none' : 'flex' }};">
      <div class="col d-flex justify-content-center align-items-center">
        <div class="spinner-grow text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </div>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
        @include('layout-admin.components.sidebar')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
          <div class=" px-md-5">

            @include('layout-admin.components.navbar')
          </div>
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            @yield('content')
            <!-- / Content -->

            <!-- Footer -->
            @include('layout-admin.components.footer')
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>

      <!-- Drag Target Area To SlideIn Menu On Small Screens -->
      <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>

    @stack('script-vendor')

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
      var toastrOptions = {
        "positionClass": "toast-top-right",
        "timeOut": "7000",
        "closeButton": true,
        "progressBar": true,
        "titleClass": "toast-title"
      };
      @if (\Session::has('success'))
        toastr["success"]('{{ \Session::get('success') }}', toastrOptions);
      @endif
      @if (\Session::has('info'))
        toastr["info"]('{{ \Session::get('info') }}', toastrOptions);
      @endif
      @if (\Session::has('error'))
        toastr["error"]('{{ \Session::get('error') }}', toastrOptions);
      @endif
    </script>
    <script>
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
      });
    </script>
    <script>
      function loaderBtn(idForm, idBtn) {
        const form = $('#' + idForm);
        const url = form.attr('action');
        const method = form.attr('method') || 'POST';
        const data = form.serialize();

        const submitBtn = $('#' + idBtn);
        submitBtn.prop('disabled', true);
        submitBtn.find('.spinner_submit').removeClass('d-none');
        submitBtn.find('.arrow_next').addClass('d-none');

        $.ajax({
          url: url,
          method: method,
          data: data,
          success: function(response) {
            // Proses berhasil
            submitBtn.prop('disabled', false);
            submitBtn.find('.spinner_submit').addClass('d-none');
            submitBtn.find('.arrow_next').removeClass('d-none');
          },
          error: function(error) {
            // Tangani error
            submitBtn.prop('disabled', false);
            submitBtn.find('.spinner_submit').addClass('d-none');
            submitBtn.find('.arrow_next').removeClass('d-none');
          }
        });
      }
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        const select2default = $('.select2default');
        const select2multiple = $('.select2multiple');
        const select2Icons = $('.select2Icons');
        if (select2default.length) {
          select2default.each(function() {
            var $this = $(this);

            // Inisialisasi ulang Select2
            $this.wrap('<div class="position-relative col"></div>').select2({
              placeholder: 'Select value',
              dropdownParent: $this.parent(),
              dropdownCssClass: 'zindex9999'
            });
          });
        }

        if (select2Icons.length) {
          // custom template to render icons
          function renderIcons(option) {
            if (!option.id) {
              return option.text;
            }
            var $icon = "<i class='" + $(option.element).data('icon') + " me-2'></i>" + option.text;

            return $icon;
          }
          select2Icons.wrap('<div class="position-relative"></div>').select2({
            templateResult: renderIcons,
            templateSelection: renderIcons,
            placeholder: 'Select value',
            dropdownParent: select2Icons.parent(),
            escapeMarkup: function(es) {
              return es;
            }
          });
        }
        if (select2multiple.length) {
          // custom template to render icons
          function renderIcons(option) {
            if (!option.id) {
              return option.text;
            }
            var $icon = "<i class='" + $(option.element).data('icon') + " me-2'></i>" + option.text;

            return $icon;
          }
          select2Icons.wrap('<div class="position-relative"></div>').select2({
            templateResult: renderIcons,
            templateSelection: renderIcons,
            placeholder: 'Select value',
            dropdownParent: select2Icons.parent(),
            escapeMarkup: function(es) {
              return es;
            }
          });
        }
      });
    </script>
    @stack('script')
  </body>

</html>
