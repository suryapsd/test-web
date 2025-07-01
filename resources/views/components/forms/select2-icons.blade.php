<div class="{{ $columnSpan }} mb-3">
  <label class="form-label" for="{{ $name }}">
    {{ $label }}
    @if ($required)
      <span style="color: red">*</span>
    @endif
  </label>
  <div class="input-group">
    <select id="{{ $name }}" name="{{ $name }}" class="select2Icons form-select {{ $class }}" data-allow-clear="true" {{ $required ? 'required' : '' }} {{ $attributes }}>
      <option value="">Select value</option>
      @foreach ($datas as $key => $value)
        <option value="{{ $key }}" data-icon="{{ $key }}">{{ $value }}</option>
      @endforeach
    </select>
  </div>
</div>
