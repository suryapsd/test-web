<div class="{{ $columnSpan }} mb-3">
  <label class="form-label" for="{{ $name }}">
    {{ $label }}
    @if ($required)
      <span style="color: red">*</span>
    @endif
  </label>
  <div class="input-group">
    <select id="{{ $name }}" name="{{ $name }}[]" multiple class="select2default form-select {{ $class }}" data-allow-clear="true" {{ $required ? 'required' : '' }} {{ $attributes }}>
      <option value="">Select value</option>
      @foreach ($datas as $item)
        @if (!blank($item->amenities))
          <optgroup label="{{ $item->name }}">
            @foreach ($item->amenities as $amenity)
              <option value="{{ $amenity->id }}" {{ in_array($amenity->id, $selectedValues ?? []) ? 'selected' : '' }}>
                {{ $amenity->name }}
              </option>
            @endforeach
          </optgroup>
        @endif
      @endforeach
    </select>
  </div>
</div>
