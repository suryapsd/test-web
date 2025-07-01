@extends('layout-admin.app')
@push('script-head')
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
@endpush
@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-2 mb-4"><span class="text-muted fw-light">{{ $section }} /</span> {{ $title }}</h4>
    <!-- Basic Layout -->
    <div class="col-xxl">
      <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="mb-0">List {{ $title }}</h5>
          @can('permission-create')
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
                  <th>Permission</th>
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
  <x-modal.modal-form id="{{ $table_id }}" title="{{ $title }}" form-action="javascript:void(0)">
    <input type="hidden" name="data_id" id="data_id">
    <x-forms.input-field name="name" label="Permission name" />
    <div class="ms-1" id="form-is-crud">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1" id="is_crud" name="is_crud" />
        <label class="form-check-label" for="is_crud"> permission for CRUD </label>
      </div>
    </div>
  </x-modal.modal-form>
  <!-- Modal -->
@endsection
@push('script-vendor')
  <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
@endpush
@push('script')
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
            url: '{{ url('permissions/data') }}',
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
              data: 'name'
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
                  @can('permission-create')
                    '<a href="javascript:void(0)" data-json="' + jsonData + '" class="btn btn-icon btn-label-primary editData{{ $table_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><span class="ti ti-edit"></span></a>' +
                  @endcan
                  @can('permission-edit')
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

    $('#addNewData{{ $table_id }}').click(function() {
      var modal = $("#ajaxModal{{ $table_id }}");
      modal.find('#modalForm').trigger("reset");

      modal.find('#data_id').val('');
      modal.find('#form-is-crud').show();
      modal.find('#titleType').text('Create');
      modal.find('#saveBtn').text('Create');
      modal.find('#saveBtn').attr('data-text', 'Create');
      modal.find('#anotherBtn').removeClass('d-none');
      modal.modal('show');
    });

    $('body').on('click', '.editData{{ $table_id }}', function() {
      var modal = $('#ajaxModal{{ $table_id }}');
      modal.find('#saveBtn').attr('data-text', 'Update');
      modal.find('#saveBtn').text('Update');
      modal.find('#anotherBtn').addClass('d-none');
      modal.find('#titleType').text("Update");

      var data = $(this).data('json');
      modal.find('#data_id').val(data.id);
      modal.find('#name').val(data.name);
      modal.find('#form-is-crud').hide();

      // Menampilkan modal
      modal.modal('show');
    });
  </script>
  @include('layout-admin.components.script-crud-simple', [
      'urlPost' => url('permissions'),
      'tableId' => $table_id,
      'defaultShowModal' => false,
  ])
@endpush
