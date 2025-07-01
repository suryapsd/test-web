<div class="{{ $columnSpan }} mb-3">
  <label class="form-label" for="{{ $name }}">
    {{ $label }}
    @if ($required)
      <span style="color: red">*</span>
    @endif
  </label>
  <div class="input-group input-group-merge">
    <input type="password" id="{{ $name }}" name="{{ $name }}" class="form-control  @error($name) is-invalid @enderror {{ $class }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }} {{ $attributes }} />
    <span class="input-group-text cursor-pointer" id="togglePassword{{ $name }}"><i class="ti ti-eye-off"></i></span>
  </div>
</div>
@push('script')
  <script>
    $(document).ready(function() {
      $('#togglePassword{{ $name }}').click(function() {
        var passwordField = $('#{{ $name }}');
        var fieldType = passwordField.attr('type') === 'password' ? 'text' : 'password';
        passwordField.attr('type', fieldType);

        // Ubah ikon mata sesuai dengan tipe input
        $(this).find('i').toggleClass('ti-eye-off ti-eye');
      });
    });
  </script>
@endpush
