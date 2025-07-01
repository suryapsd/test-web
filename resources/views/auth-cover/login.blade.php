@extends('layout-admin.auth.app')
@section('content')
  <div class="authentication-wrapper authentication-cover authentication-bg overflow-hidden">
    <div class="authentication-inner row">
      <!-- /Left Text -->
      <div class="d-none d-lg-flex col-lg-7 p-0">
        <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
          <img src="{{ asset('assets/img/auth/login.svg') }}" alt="auth-login-cover" class="img-fluid my-5 auth-illustration" />
          {{-- <img src="{{ asset('assets/img/illustrations/bg-shape-image-light.png') }}" alt="auth-login-cover" class="platform-bg" data-app-light-img="illustrations/bg-shape-image-light.png" data-app-dark-img="illustrations/bg-shape-image-dark.png" /> --}}
        </div>
      </div>
      <!-- /Left Text -->

      <!-- Register -->
      <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
        <div class="w-px-400 mx-auto">
          <h4 class="mb-1 fw-bold">Welcome to Diskominfo! 👋</h4>
          <p class="mb-4">Please log in using the registered account!</p>
          @if (session('status'))
            <div class="alert alert-danger" role="alert">
              {{ session('status') }}
            </div>
          @endif
          <form id="loginForm" class="mb-3" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter your email" autocomplete="email" autofocus required />
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-password-toggle mb-1">
              <label class="form-label" for="password">Password</label>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" autocomplete="current-password" required />
                <span class="input-group-text cursor-pointer" id="togglePassword"><i class="ti ti-eye-off"></i></span>
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="d-flex justify-content-between mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember" name="remember" value="true" {{ old('remember') ? 'checked' : '' }} />
                <label class="form-check-label" for="remember">
                  Remember me
                </label>
              </div>
              <a href="/forgot-password">
                <small>Forgot Password?</small>
              </a>
            </div>
            <button id="loginButton" type="submit" class="btn btn-primary d-flex d-grid w-100">
              <span class="spinner-border spinner-border-sm me-2 spinner_submit d-none"></span>
              <span class="align-middle">Login</span>
            </button>
          </form>

          <p class="text-center">
            <span>New on our platform?</span>
            <a href="/register">
              <span>Create an account</span>
            </a>
          </p>
        </div>
      </div>
      <!-- /Register -->
    </div>
  </div>
  @push('script')
    <script>
      $(document).ready(function() {
        $('#loginForm').submit(function() {
          loaderBtn('loginForm', 'loginButton');
        });
      });

      document.onreadystatechange = function() {
        if (document.readyState !== "complete") {
          $('#loader').show();
        } else {
          $('#loader').hide();
        }
      };
    </script>
  @endpush
@endsection
