@extends('layout-admin.auth.app')
@section('content')
  <div class="container main-section pt-3 overflow-hidden">
    <div class="authentication-wrapper authentication-basic px-4">
      <div class="authentication-inner py-4">
        <!-- Verify Email -->
        <div class="card">
          <div class="card-body">
            <h4 class="mb-1 pt-2">Verify your email ✉️</h4>
            {{-- <p class="text-start mb-4">
            Account activation link sent to your email address: hello@example.com Please follow the link inside to
            continue.
          </p> --}}
            @if (session('resent'))
              <div class="alert alert-success" role="alert">
                {{ session('resent') }}
              </div>
            @endif
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif

            <p class="text-start mb-4">
              {{ __('Before proceeding, please check your email for a verification link.') }}
              {{ __('If you did not receive the email') }},
            </p>

            <form id="verifyForm" class="d-inline" method="POST" action="{{ route('verification.send') }}">
              @csrf
              <button id="verifyButton" type="submit" class="btn btn-primary d-flex d-grid w-100">
                <span class="spinner-border spinner-border-sm me-2 spinner_submit d-none"></span>
                <span class="align-middle">{{ __('Click here to request another') }}</span>
              </button>
            </form>
            {{-- <p class="text-center mb-0">
            Didn't get the mail?
            <a href="javascript:void(0);"> Resend </a>
          </p> --}}
          </div>
        </div>
        <!-- /Verify Email -->
      </div>
    </div>
  </div>

  @push('script')
    <script>
      $(document).ready(function() {
        $('#verifyForm').submit(function() {
          loaderBtn('verifyForm', 'verifyButton');
        });
      });
    </script>
  @endpush
@endsection
