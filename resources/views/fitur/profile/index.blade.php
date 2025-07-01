@extends('layout-admin.app', [
    'hideLoader' => false,
])
@push('script-head')
  <link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css' rel='stylesheet' type='text/css' />
  <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js'></script>
@endpush
@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-2 mb-3"><span class="text-muted fw-light">{{ $section }} /</span> {{ $title }}</h4>
    <div class="nav-align-top mb-4">
      <ul class="nav nav-pills mb-3" role="tablist">
        <li class="nav-item">
          <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home" aria-selected="true">
            Profile
          </button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile" aria-selected="false">
            User Account
          </button>
        </li>
      </ul>
      <div class="tab-content" style="padding: 0; box-shadow: none !important;">
        <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
          <div class="card">
            <div style="background-color: #FAF8F8" class="card-header py-3 px-md-4 border border-3 border-start-0 border-bottom-0 border-end-0 border-primary rounded rounded-top d-flex align-items-center justify-content-between">
              <h5 class="card-title m-0" id="title_form"><button type="button" disabled class="btn btn-icon btn-label-primary me-2"><span class="ti ti-file-description"></span></button>Basic Information</h5>
            </div>
            <hr class="m-0" />
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $msg)
                    <li>{{ $msg }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('profile.post') }}" id="form_data" method="POST" enctype="multipart/form-data" class="card-body">
              @csrf
              <div class="row px-md-5">
                <input type="text" name="data_id" value="{{ $user->id }}" hidden>
                <x-forms.input-field column-span="col-md-12" name="name" label="Full Name" value="{{ $user->name }}" />
                <x-forms.input-field column-span="col-md-6" name="nik" label="NIK" value="{{ $user->nik }}" readonly required="false" />
                <x-forms.input-field column-span="col-md-6" name="phone" value="{{ $user->phone }}" />
                <x-forms.input-field column-span="col-md-6" type="date" name="date_of_birth" value="{{ $user->date_of_birth }}" />
                <x-forms.input-field column-span="col-md-6" name="job" value="{{ $user->job }}" />
                <x-forms.text-area-field name="address" value="{{ $user->address }}" required="false">{{ $user->address }}</x-forms.text-area-field>
              </div>
              <hr class="mt-2 mb-3 mx-n4" />
              <div class="px-md-5">
                <button type="submit" id="saveBtn" class="btn btn-primary me-sm-3 me-1">Save</button>
              </div>
            </form>
          </div>
        </div>
        <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
          <div class="card">
            <div style="background-color: #FAF8F8" class="card-header py-3 px-md-4 border border-3 border-start-0 border-bottom-0 border-end-0 border-primary rounded rounded-top d-flex align-items-center justify-content-between">
              <h5 class="card-title m-0" id="title_form"><button type="button" disabled class="btn btn-icon btn-label-primary me-2"><span class="ti ti-file-description"></span></button>Security</h5>
            </div>
            <hr class="m-0" />
            <form action="{{ route('profile.password_update') }}" id="form_data" method="POST" enctype="multipart/form-data" class="card-body">
              @csrf
              <div class="row px-md-5">
                <x-forms.input-field name="email" value="{{ Auth::user()->email }}" disabled required="false" />
                <x-forms.password-field column-span="col-md-12" type="password" name="current_password" />
                <x-forms.password-field column-span="col-md-6" type="password" name="password" label="New password" />
                <x-forms.password-field column-span="col-md-6" type="password" name="password_confirmation" label="Confirm new password" />
              </div>
              <hr class="mt-2 mb-3 mx-n4" />
              <div class="px-md-5">
                <button type="submit" id="saveBtn" class="btn btn-primary me-sm-3 me-1">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('script-vendor')
@endpush
@push('script')
  <script>
    $('#form_data').submit(function() {
      loaderBtn('form_data', 'saveBtn');
    });
  </script>
@endpush
