@extends('layout-admin.auth.app')
@section('content')
  <div class="container main-section pt-3 overflow-hidden">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner py-4">
        <!-- Forgot Password -->
        <div class="card">
          <div class="card-body">
            <h4 class="mb-1 pt-2">Forgot Password? 🔒</h4>
            <p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif
            <form id="forgotForm" method="POST" action="{{ route('password.email') }}">
              @csrf
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter your email" autofocus required autocomplete="email" />
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <button id="forgotButton" type="submit" class="btn btn-primary d-flex d-grid w-100">
                <span class="spinner-border spinner-border-sm me-2 spinner_submit d-none"></span>
                <span class="align-middle">Send Reset Link</span>
              </button>
            </form>
            <div class="text-center mt-2">
              <a href="/login"><i class="ti ti-arrow-narrow-left mb-1"></i>Back to login</a>
            </div>
          </div>
        </div>
        <!-- /Forgot Password -->
      </div>
    </div>
  </div>

  @push('script')
    <script>
      $(document).ready(function() {
        $('#forgotForm').submit(function() {
          loaderBtn('forgotForm', 'forgotButton');
        });
      });
    </script>
  @endpush
@endsection
