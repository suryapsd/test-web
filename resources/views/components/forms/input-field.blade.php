<div class="{{ $columnSpan }} mb-3">
  <label class="form-label" for="{{ $name }}">
    {{ $label }}
    @if ($required)
      <span style="color: red">*</span>
    @endif
  </label>
  <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" class="form-control {{ $class }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }} {{ $attributes }} />
</div>
