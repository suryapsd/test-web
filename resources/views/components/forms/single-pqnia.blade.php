@push('script-head')
  <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
  <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
  <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
  <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
  <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
  <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
  <script>
    FilePond.registerPlugin(
      FilePondPluginImagePreview,
      FilePondPluginFileValidateType,
      FilePondPluginFileValidateSize,
    );
  </script>
@endpush

<div class="{{ $columnSpan }} mb-3 ">
  <label class="form-label" for="{{ $name }}">
    {{ $label }}
    @if ($required)
      <span style="color: red">*</span>
    @endif
  </label>
  <input type="file" class="pond" name="{{ $name }}" id="{{ $name }}" {{ $required ? 'required' : '' }} data-existing-files="{{ $images ?? null }}" data-allow-reorder="true" label-max-file-size-exceeded="File size is too large" label-max-file-size="Maximum file size is {filesize}" data-max-files="20" label-max-total-file-size="Maximum 20 images" label-idle="{{ 'Drag and drop images or <span class="filepond--label-action"> upload </span>' }}">
</div>

@push('script-vendor')
@endpush

{{-- @push('script')
  <script>
    var pond = document.getElementById('{{ $name }}');
    if (pond) {
      FilePond.create(pond, {
        acceptedFileTypes: ['image/png', 'image/jpg', 'image/jpeg', 'image/webp'],
        storeAsFile: true
      });
    }
  </script>
@endpush --}}
@push('script')
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var pondElement = document.querySelector('[name="{{ $name }}"]');
      if (!pondElement) return;

      var existingFiles = pondElement.getAttribute('data-existing-files') || null;
      // console.log("Parsed existing files:", existingFiles);

      // Inisialisasi FilePond
      const filePondInstance = FilePond.create(pondElement, {
        acceptedFileTypes: ['image/png', 'image/jpg', 'image/jpeg', 'image/webp'],
        storeAsFile: true,
      });

      // Hapus file sebelumnya & tambahkan file baru
      if (existingFiles) {
        filePondInstance.removeFiles(); // Hapus jika ada file sebelumnya

        const imageUrl = '{{ url('/') }}/' + existingFiles;
        filePondInstance.addFile(imageUrl)
          .then(() => console.log())
          .catch((error) => console.error(`Gagal memuat file ${imageUrl}:`, error));
      }
    });
  </script>
@endpush
