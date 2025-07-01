@extends('layout-admin.auth.app')
@section('content')
  <div class="authentication-wrapper authentication-cover authentication-bg">
    <div class="authentication-inner row">
      <!-- /Left Text -->
      <div class="d-none d-lg-flex col-lg-7 p-0">
        <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
          <img src="{{ asset('assets/img/auth/register.svg') }}" alt="auth-register-cover" class="img-fluid my-5 auth-illustration" />
          {{-- <img src="{{ asset('assets/img/illustrations/bg-shape-image-light.png') }}" alt="auth-register-cover" class="platform-bg" data-app-light-img="illustrations/bg-shape-image-light.png" data-app-dark-img="illustrations/bg-shape-image-dark.png" /> --}}
        </div>
      </div>
      <!-- /Left Text -->

      <!-- Register -->
      <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
        <div class="w-px-400 mx-auto">
          <h4 class="mb-1 fw-bold">Sign Up</h4>
          <p class="mb-4">Please sign up to get more experience!</p>
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif
          <form id="regisForm" class="mb-2" action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-2">
              <label class="form-label" for="nik">Full Name<span style="color: red">*</span></label>
              <input type="text" id="nik" name="nik" value="{{ old('nik') }}" class="form-control @error('nik') is-invalid @enderror" placeholder="xxxxxxxx" autofocus required />
              @error('nik')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-2">
              <label class="form-label" for="name">Full Name<span style="color: red">*</span></label>
              <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="John" required />
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-2">
              <label for="phone" class="form-label">Phone Number<span style="color: red">*</span></label>
              <input type="number" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Enter your phone number" required />
              @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-2">
              <label for="email" class="form-label">Email<span style="color: red">*</span></label>
              <input type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter your email" required />
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-2 form-password-toggle">
              <label class="form-label" for="password">Password<span style="color: red">*</span></label>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                <span class="input-group-text cursor-pointer" id="togglePassword"><i class="ti ti-eye-off"></i></span>
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="mb-2 form-password-toggle">
              <label class="form-label" for="password">Confirm Password<span style="color: red">*</span></label>
              <div class="input-group input-group-merge">
                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                <span class="input-group-text cursor-pointer" id="confirmPassword"><i class="ti ti-eye-off"></i></span>
              </div>
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" />
                <label class="form-check-label" for="terms-conditions">
                  I agree to
                  <a href="javascript:void(0);">privacy policy & terms</a>
                </label>
              </div>
            </div>
            <button id="regisButton" type="submit" class="btn btn-primary d-flex d-grid w-100">
              <span class="spinner-border spinner-border-sm me-2 spinner_submit d-none"></span>
              <span class="align-middle">Sign Up</span>
            </button>
          </form>

          <p class="text-center">
            <span>Already have an account?</span>
            <a href="/login">
              <span>Login</span>
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
        $('#regisForm').submit(function() {
          loaderBtn('regisForm', 'regisButton');
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
