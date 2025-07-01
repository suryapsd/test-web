<div class="{{ $columnSpan }} mb-3">
  <label class="form-label" for="{{ $name }}">
    {{ $label }}
    @if ($required)
      <span style="color: red">*</span>
    @endif
  </label>
  <textarea class="form-control {{ $class }}" id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }} {{ $attributes }}>{{ $slot }}</textarea>
</div>
