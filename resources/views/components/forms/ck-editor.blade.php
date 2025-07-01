<div class="{{ $columnSpan }} mb-3">
  <label class="form-label" for="{{ $name }}">
    {{ $label }}
    @if ($required)
      <span style="color: red">*</span>
    @endif
  </label>
  <textarea name="{{ $name }}" id="{{ $name }}" cols="5" rows="10" class="form-control ckeditor">{{ $slot }}</textarea>
</div>
@push('script')
  <script>
    var editors = {};
    document.addEventListener("DOMContentLoaded", function() {
      const editorElement = document.getElementById("{{ $name }}");
      if (editorElement) {
        ClassicEditor.create(editorElement, {
            ckfinder: {
              uploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            },
          })
          .then(editor => {
            editors[editorElement.id] = editor; // Simpan instance ke dalam objek editors
          })
          .catch(error => {
            console.error(error);
          });
      }
    });
  </script>
@endpush
