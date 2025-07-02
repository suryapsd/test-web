@extends('layout-admin.app')
@push('script-head')
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />\
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
@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-2 mb-4"><span class="text-muted fw-light">{{ $section }} /</span> {{ $title }}</h4>
    <!-- Basic Layout -->
    <div class="col-xxl">
      <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="mb-0">List {{ $title }}</h5>
          @can('account-create')
            <a href="javascript:void(0)" id="addNewData{{ $table_id }}" class="btn btn-primary">
              <i class="ti ti-plus"></i>&nbsp;New Data
            </a>
          @endcan
        </div>
        <hr class="my-0" />
        <div class="card-body">
          <div class="table-responsive">
            <table id="{{ $table_id }}" class="table border-top table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Kategori Layanan</th>
                  <th>Jenis Layanan</th>
                  <th>Status</th>
                  <th>Description</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Layout -->
  <x-modal.modal-form id="{{ $table_id }}" title="{{ $title }}" size="modal-lg" form-action="javascript:void(0)">
    <input type="hidden" name="data_id" id="data_id">
    <x-forms.input-field label="Nama" name="name" value="{{ Auth::user()->name }}" columnSpan="col-md-6" required="false" readonly />
    <x-forms.input-field label="NIK" name="nik" value="{{ Auth::user()->nik }}" columnSpan="col-md-6" required="false" readonly />
    <x-forms.select2-default name="layanan_kategori_id" label="Kategori Layanan" :datas="$kategoris" required="true" class="" columnSpan="col-12" />
    <x-forms.select2-default name="layanan_jenis_id" label="Jenis Layanan" :datas="$jenis" required="true" class="" columnSpan="col-12" disabled />
    <div id="dokumen_wajib"></div>
    <x-forms.text-area-field name="description" required="false" />
  </x-modal.modal-form>
  <!-- Modal -->
@endsection
@push('script-vendor')
  <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
@endpush
@push('script')
  <script>
    $('#layanan_kategori_id').change(function() {
      const layanan_kategori_id = $('#layanan_kategori_id').find(':selected').val();
      getDropdwnSelect('#layanan_jenis_id', layanan_kategori_id)
    });

    function getDropdwnSelect(selectId, layanan_kategori_id, selectedValue = null) {
      const dropdown = $(selectId);

      if (layanan_kategori_id) {
        // Reset dropdown & show loading
        dropdown
          .empty()
          .append(`<option disabled selected>Loading...</option>`)
        // .prop('disabled', true);

        $.ajax({
          url: '{{ url('jenis-layanan/data') }}',
          type: "GET",
          data: {
            layanan_kategori_id: layanan_kategori_id
          },
          success: function(response) {
            const data = response.data || [];

            dropdown.empty().append(`<option value="">Select value</option>`);

            data.forEach(item => {
              const selected = item.id === selectedValue ? 'selected' : '';
              dropdown.append(`<option value="${item.id}" ${selected}>${item.name}</option>`);
            });

            dropdown.prop('disabled', false);
            if (selectedValue) {
              dropdown.trigger('change');
            }
          },
          error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
            dropdown.empty().append(`<option disabled selected>Failed to load data</option>`);
            dropdown.prop('disabled', false);
          }
        });
      }
    }

    $('#layanan_jenis_id').change(function() {
      const layanan_jenis_id = $('#layanan_jenis_id').find(':selected').val();
      getDokumenWajib('#dokumen_wajib', layanan_jenis_id)
    });

    function getDokumenWajib(tagId, layanan_jenis_id) {
      const container = $(tagId);

      if (layanan_jenis_id) {
        container.html('<p>Loading...</p>');
        $.ajax({
          url: '/jenis-layanan/' + layanan_jenis_id,
          type: "GET",
          success: function(response) {
            const dokumens = response.data.dokumen_wajibs || [];
            container.empty();

            dokumens.forEach(item => {
              const name = `file[${item.id}]`;
              const id = `file_${item.id}`;
              const label = item.name;
              const allowedMimes = item.type !== 'all' ? item.type : 'jpg,jpeg,png,pdf';

              const html = `
            <div class="col-md-12 mb-3">
              <label class="form-label" for="${id}">${label} <span style="color:red">*</span></label>
              <input type="file"
                     class="pond"
                     name="${name}"
                     id="${id}"
                     required
                     data-allowed-mimes="${allowedMimes}"
                     label-idle='Drag and drop or <span class="filepond--label-action">Upload</span>'>
            </div>
          `;
              container.append(html);
            });

            // Aktifkan FilePond untuk setiap input
            setTimeout(() => {
              document.querySelectorAll('.pond').forEach((pondInput) => {
                const mimeAttr = pondInput.getAttribute('data-allowed-mimes');
                const mimeList = mimeAttr ? mimeAttr.split(',').map(m => `image/${m.trim()}`) : [];

                // Khusus untuk PDF, ubah dari image/pdf ke application/pdf
                const acceptedTypes = mimeList.map(mime => {
                  if (mime.includes('pdf')) return 'application/pdf';
                  if (mime.includes('jpg') || mime.includes('jpeg') || mime.includes('png') || mime.includes('webp'))
                    return mime.replace('image/', 'image/');
                  return mime;
                });

                FilePond.create(pondInput, {
                  acceptedFileTypes: acceptedTypes,
                  storeAsFile: true,
                  labelFileTypeNotAllowed: 'Tipe file tidak diperbolehkan.',
                  fileValidateTypeLabelExpectedTypes: 'Tipe file harus: {allTypes}',
                });
              });
            }, 100);
          },
          error: function() {
            // container.html('<div class="text-danger">Gagal memuat dokumen wajib.</div>');
          }
        });
      }
    }
  </script>
  <script>
    'use strict';

    var table_{{ $table_id }};

    // Datatable (jquery)
    document.addEventListener("DOMContentLoaded", function() {
      // Variable declaration for table
      var dt_view = $('#{{ $table_id }}');

      // Users datatable
      if (dt_view.length) {
        table_{{ $table_id }} = dt_view.DataTable({
          ajax: {
            url: '{{ url('layanan/data') }}',
            type: "GET",
            dataSrc: 'data'
          }, // JSON file to add data
          dom: '<"row mx-2"' +
            '<"col-md-2 p-0"<""l>>' +
            '<"col-md-10 p-0"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"f<"">B>>' +
            '>t' +
            '<"row mx-2"' +
            '<"col-sm-12 col-md-6 p-0"i>' +
            '<"col-sm-12 col-md-6 p-0"p>' +
            '>',
          scrollX: true,
          scrollCollapse: true,
          language: {
            sLengthMenu: '_MENU_',
            search: '',
            searchPlaceholder: 'Search..'
          },
          pageLength: 25,
          lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All']
          ],
          order: [],
          // Buttons with Dropdown
          buttons: [],
          columns: [
            // columns according to JSON
            {
              data: 'id'
            },
            {
              data: 'user.name'
            },
            {
              data: 'layanan_jenis.layanan_kategori.name'
            },
            {
              data: 'layanan_jenis.name'
            },
            {
              data: 'status'
            },
            {
              data: 'description'
            },
            {
              data: 'id'
            }
          ],
          columnDefs: [{
              // For Responsive
              className: 'control text-center',
              searchable: false,
              orderable: true,
              responsivePriority: 2,
              targets: 0,
              render: function(data, type, full, meta) {
                return meta.row + 1;
              }
            },
            {
              // Actions
              className: 'text-center',
              targets: -1,
              title: 'Actions',
              searchable: false,
              orderable: false,
              render: function(data, type, full, meta) {
                var jsonData = JSON.stringify(full).replace(/"/g, '&quot;');
                return (
                  '<div class="d-flex justify-content-center align-items-center gap-1">' +
                  @can('account-create')
                    '<a href="javascript:void(0)" data-json="' + jsonData + '" class="btn btn-icon btn-label-primary editData{{ $table_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><span class="ti ti-edit"></span></a>' +
                  @endcan
                  @can('account-edit')
                    '<a href="javascript:void(0)" data-json="' + jsonData + '" class="btn btn-icon btn-label-danger deleteData{{ $table_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Data" delete-record"><span class="ti ti-trash"></span></a>' +
                  @endcan
                  '</div>'
                );
              }
            }
          ],
          initComplete: function() {
            $('#page-loader').hide();
            // Inisialisasi tooltip di dalam fungsi ini
            $('[data-bs-toggle="tooltip"]').tooltip();
          },
        });
        table_{{ $table_id }}.on('draw', function() {
          $('[data-bs-toggle="tooltip"]').tooltip();
        });
        $('.dataTables_filter').html('<div class="input-group flex-nowrap"><span class="input-group-text" id="addon-wrapping"><i class="tf-icons ti ti-search"></i></span><input type="search" class="form-control form-control-sm" placeholder="Type in to Search" aria-label="Type in to Search" aria-describedby="addon-wrapping"></div>');
        $('[name="{{ $table_id }}_length"]').addClass('mx-0');
        // Handle search input changes using DataTables API
        $('#{{ $table_id }}_filter input').on('keyup', function() {
          //   $('#addon-wrapping').html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>')
          table_{{ $table_id }}.search(this.value).draw();
          //   table.on('draw', function() {
          //     $('#addon-wrapping').html('<i class="tf-icons ti ti-search"></i>');
          //   });
        });
      }
    });

    $('body').on('click', '.editData{{ $table_id }}', function() {
      var modal = $('#ajaxModal{{ $table_id }}');
      modal.find('#saveBtn').attr('data-text', 'Update');
      modal.find('#saveBtn').text('Update');
      modal.find('#anotherBtn').addClass('d-none');
      modal.find('#titleType').text("Update");

      var data = $(this).data('json');
      modal.find('#layanan_kategori_id').val(data.layanan_jenis.layanan_kategori.id).trigger('change');
      getDropdwnSelect('#layanan_jenis_id', data.layanan_jenis.layanan_kategori.id, data.layanan_jenis.id)
      modal.find('#data_id').val(data.id);
      modal.find('#description').val(data.description);
      modal.find('#name').val(data.user.name);
      modal.find('#nik').val(data.user.nik);
      modal.find('#user_id').val(data.user.id);

      // Menampilkan modal
      modal.modal('show');
    });
  </script>
  @include('layout-admin.components.script-crud-simple', [
      'urlPost' => url('layanan'),
      'tableId' => $table_id,
  ])
@endpush
