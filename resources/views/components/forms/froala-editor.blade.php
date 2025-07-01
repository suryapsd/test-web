@push('script-head')
  <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>
@endpush

<div class="{{ $columnSpan }} mb-3">
  <label class="form-label" for="{{ $name }}">
    {{ $label }}
    @if ($required)
      <span style="color: red">*</span>
    @endif
  </label>
  <textarea name="{{ $name }}" id="{{ $name }}" cols="5" rows="5" class="form-control" {{ $required ? 'required' : '' }}>{{ $slot }}</textarea>
</div>

@push('script-vendor')
@endpush

@push('script')
  <script>
    new FroalaEditor("#{{ $name }}");
  </script>
@endpush
