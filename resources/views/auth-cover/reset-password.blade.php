@extends('layout-admin.auth.app')
@section('content')
  <div class="container main-section pt-3 overflow-hidden">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner py-4">
        <!-- Reset Password -->
        <div class="card">
          <div class="card-body">
            <h4 class="mb-1 pt-2">Reset Password 🔒</h4>
            {{-- <p class="mb-4">for <span class="fw-bold">john.doe@email.com</span></p> --}}
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif
            <form id="resetForm" method="POST" action="{{ route('password.update') }}">
              @csrf
              <input type="hidden" name="token" value="{{ $request->route('token') }}">
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input readonly type="email" value="{{ $request->email ?? old('email') }}" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter your email" required autocomplete="email" autofocus />
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password">New Password</label>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required autocomplete="new-password" />
                  <span class="input-group-text cursor-pointer" id="togglePassword"><i class="ti ti-eye-off"></i></span>
                  @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <div class="input-group input-group-merge">
                  <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required autocomplete="new-password" />
                  <span class="input-group-text cursor-pointer" id="confirmPassword"><i class="ti ti-eye-off"></i></span>
                </div>
              </div>
              <button id="resetButton" type="submit" class="btn btn-primary d-flex d-grid w-100">
                <span class="spinner-border spinner-border-sm me-2 spinner_submit d-none"></span>
                <span class="align-middle">Set new password</span>
              </button>
              <div class="text-center mt-2">
                <a href="/login"><i class="ti ti-arrow-narrow-left mb-1"></i>Back to login</a>
              </div>
            </form>
          </div>
        </div>
        <!-- /Reset Password -->
      </div>
    </div>
  </div>

  @push('script')
    <script>
      $(document).ready(function() {
        $('#resetForm').submit(function() {
          loaderBtn('resetForm', 'resetButton');
        });
      });
    </script>
  @endpush
@endsection
