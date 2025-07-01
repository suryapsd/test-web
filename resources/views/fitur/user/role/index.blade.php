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
          @can('role-create')
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
                  <th>Role</th>
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
  <x-modal.modal-form id="{{ $table_id }}" title="{{ $title }}" form-action="javascript:void(0)" size="modal-lg">
    <input type="hidden" name="data_id" id="data_id">
    <div class="col-12 mb-4">
      <label class="form-label" for="name">Role Name</label>
      <input type="text" id="name" name="name" class="form-control" placeholder="Enter a role name" tabindex="-1" />
    </div>
    <div class="col-12">
      <h5>Role Permissions</h5>
      <!-- Permission table -->
      <div class="table-responsive">
        <table class="table table-flush-spacing">
          <tbody>
            <tr>
              <td class="text-nowrap fw-semibold d-flex gap-2">
                Administrator Access
                <i class="ti ti-info-circle" data-bs-oggle="tooltip" data-bs-placement="top" title="Allows a full access to the system"></i>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="selectAll" />
                  <label class="form-check-label" for="selectAll"> Select All </label>
                </div>
              </td>
              <td>
              </td>
            </tr>
          </tbody>
        </table>
        <table class="table table-flush-spacing">
          <tbody id="permisionCheckboxContainer"></tbody>
        </table>
      </div>
      <!-- Permission table -->
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
            url: '{{ url('roles/data') }}',
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
                  '<a href="javascript:void(0)" data-json="' + jsonData + '" class="btn btn-icon btn-label-primary editData{{ $table_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><span class="ti ti-edit"></span></a>' +
                  @can('role-delete')
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

    function fillPermissionCheckbox(selectedPermissionIds) {
      $.ajax({
        url: '{{ url('permissions/data') }}',
        method: 'GET',
        success: function(data) {
          const permisionCheckboxContainer = $('#permisionCheckboxContainer');
          permisionCheckboxContainer.empty(); // Kosongkan container sebelum mengisi ulang
          const permissionData = data.data;

          // 1. **Mengelompokkan berdasarkan prefix utama**
          let groupedPermissions = {};

          permissionData.forEach(function(permission) {
            let parts = permission.name.split('-');
            let prefix = parts.length > 2 ? parts[0] + '-' + parts[1] : parts[0]; // Jika lebih dari 2 bagian, gabungkan dua pertama

            if (!groupedPermissions[prefix]) {
              groupedPermissions[prefix] = [];
            }

            groupedPermissions[prefix].push(permission);
          });

          // 2. **Looping tiap grup permission**
          Object.keys(groupedPermissions).forEach(function(prefix) {
            var permissions = groupedPermissions[prefix];

            // Ambil hanya permission dengan action `list, create, edit, delete`
            const relevantPermissions = permissions.filter(permission =>
              permission.name.endsWith('-list') ||
              permission.name.endsWith('-create') ||
              permission.name.endsWith('-edit') ||
              permission.name.endsWith('-delete')
            ).map(permission => ({
              id: permission.id,
              name: permission.name,
              label_name: permission.name.replace(prefix + '-', '') // Hapus prefix dari label
            }));

            if (relevantPermissions.length > 0) {
              let name = cleanPermissionName(prefix); // Ambil prefix untuk judul
              let checkbox = `
            <tr>
              <td class="text-nowrap fw-semibold">Manajemen ${name.charAt(0).toUpperCase()}${name.slice(1)}</td>
              <td>
                <div class="d-flex justify-content-md-end">`;

              relevantPermissions.forEach(permission => {
                const isChecked = selectedPermissionIds.some(selected => selected.name === permission.name);
                checkbox += `
              <div class="form-check me-3 me-lg-5">
                <input class="form-check-input" type="checkbox" value="${permission.name}" id="permission_id_${permission.id}" name="permission_id[]" ${isChecked ? 'checked' : ''} />
                <label class="form-check-label" for="permission_id_${permission.id}"> ${permission.label_name} </label>
              </div>`;
              });

              checkbox += `
                </div>
              </td>
            </tr>
          `;

              permisionCheckboxContainer.append(checkbox);
            }
          });
        },
        error: function(error) {
          toastr["error"](error.responseJSON.message, toastrOptions);
          console.error('Error fetching permission data:', error.responseText);
        }
      });
    }

    function cleanPermissionName(permission) {
      // Hapus suffix dari permission untuk mendapatkan nama bersih
      return permission.replace(/-(list|create|edit|delete)$/, '');
    }


    $('#ajaxModel').on('show.bs.modal', function() {
      $('#loader').hide();
    });

    $('#addNewData{{ $table_id }}').click(function() {
      var modal = $("#ajaxModal{{ $table_id }}");
      modal.find('#modalForm').trigger("reset");
      modal.find('#data_id').val('');
      modal.find('#titleType').text('Create');
      modal.find('#saveBtn').text('Create');
      modal.find('#saveBtn').attr('data-text', 'Create');
      modal.find('#anotherBtn').removeClass('d-none');
      modal.modal('show');
      const selectedPermissionIds = [];
      fillPermissionCheckbox(selectedPermissionIds);
    });

    $('#selectAll').click(function() {
      var isChecked = $(this).prop("checked");
      var modal = $("#ajaxModal{{ $table_id }}");
      modal.find('.form-check-input').prop("checked", isChecked);
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
      const selectedPermissionIds = data.permissions;
      fillPermissionCheckbox(selectedPermissionIds)

      // Menampilkan modal
      modal.modal('show');
    });

    // Function to reset form and remove errors when modal is closed
    $("#ajaxModal{{ $table_id }}").on("hidden.bs.modal", function() {
      resetModal('{{ $table_id }}')
    });

    function resetModal(table_id) {
      var modalForm = $('#modalForm' + table_id);
      modalForm.trigger("reset");

      if (modalForm.find('.select2default')) {
        modalForm.find('.select2default').val(null).trigger('change');
      }
      if (modalForm.find('.select2Icons')) {
        modalForm.find('.select2Icons').val(null).trigger('change');
      }

      modalForm.find(".is-invalid").removeClass("is-invalid");
      modalForm.find(".invalid-feedback").text("");
    }

    // function removeErrors() {
    //   $(".form-control").removeClass("is-invalid");
    //   $(".invalid-feedback").text("");
    // }

    var toastrOptions = {
      "positionClass": "toast-top-right",
      "timeOut": "7000",
      "closeButton": true,
      "progressBar": true,
      "titleClass": "toast-title"
    };

    $('.submitBtn{{ $table_id }}').click(function(e) {
      e.preventDefault();

      // Get the form data
      var submitBtn = $(this);
      var initiate = submitBtn.attr('data-initiate');
      var modalForm = $('#modalForm{{ $table_id }}');

      modalForm.find(".ckeditor").each(function() {
        let editorId = this.id;
        if (editors[editorId]) {
          $(this).val(editors[editorId].getData());
        }
      });

      var formData = new FormData(modalForm[0]);
      formData.append('_method', 'POST');

      $.ajax({
        url: '{{ url('roles') }}',
        data: formData,
        type: "POST",
        dataType: 'json',
        contentType: false,
        processData: false,
        beforeSend: function() {
          submitBtn.html('<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Processing...');
          submitBtn.prop("disabled", true);

          $('.is-invalid').removeClass('is-invalid');
          $('.invalid-feedback').text('');
        },
        success: function(data) {
          modalForm.trigger("reset");
          resetModal('{{ $table_id }}')
          if (initiate === '0') {
            $('#ajaxModal{{ $table_id }}').modal('hide');
          } else {
            modalForm.find('.ckeditor').each(function() {
              let editorId = this.id;
              if (editors[editorId]) {
                editors[editorId].setData('');
              }
            });

            if (typeof FilePond !== 'undefined') {
              const filePondInstance = FilePond.find(document.querySelector('.pond'));
              if (filePondInstance) {
                filePondInstance.removeFiles();
              }
            };
          }
          if (data.status) {
            toastr["success"](data.message, toastrOptions);
            table_{{ $table_id }}.ajax.reload();
          } else {
            toastr["warning"](data.message, toastrOptions);
          }
        },
        error: function(data) {
          toastr["error"](data.message, toastrOptions);
          // Error handling for specific input fields
          if (data.status === 422) {
            let errors = data.responseJSON.errors;

            // Hapus pesan error dan class is-invalid sebelum menambahkan yang baru
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            $.each(errors, function(key, value) {
              // Tambahkan class is-invalid pada input atau select2
              let input = $(`#${key}`);
              input.addClass('is-invalid');

              if (input.hasClass('select2-hidden-accessible')) {
                // Jika input adalah elemen Select2
                let select2Selection = input.next('.select2');
                select2Selection.after(`<div class="invalid-feedback">${value[0]}</div>`);

              } else if (input.hasClass('ckeditor')) {
                // Jika input adalah elemen ckeditor
                let ckeditor = input.next('.ck-editor');
                ckeditor.after(`<div class="invalid-feedback">${value[0]}</div>`);

              } else {
                // Untuk elemen selain Select2, tambahkan pesan error di bawah input
                if (input.next('.invalid-feedback').length === 0) {
                  input.after(`<div class="invalid-feedback">${value[0]}</div>`);
                }
              }
            });
          }
        },
        complete: function() {
          var text = submitBtn.attr('data-text');
          submitBtn.html(text);
          submitBtn.prop("disabled", false);
        }
      });
    });

    // Function to delete data
    $('body').on('click', '.deleteData{{ $table_id }}', function() {
      var data = $(this).data('json');
      Swal.fire({
        icon: 'warning',
        text: 'Delete data: ' + (data.name || data.title || data.service_name) + '?',
        showCancelButton: true,
        confirmButtonText: "Yes, Delete!",
        cancelButtonText: "Cancel",
        reverseButtons: true,
        customClass: {
          title: 'p-0 m-0',
          htmlContainer: 'p-0 mt-1 mb-2',
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-danger',
        },
        buttonsStyling: false
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '{{ url('roles') }}/' + data.id,
            type: "DELETE",
            dataType: "JSON",
            success: function(data) {
              if (data.status) {
                toastr["success"](data.message, toastrOptions);
                // Swal.fire('Sukses', data.message, 'success');
                // Reload the DataTable after successful deletion
                table_{{ $table_id }}.ajax.reload();
              } else {
                toastr["warning"](data.message, toastrOptions);
                // Swal.fire('Gagal', data.message, 'error');
              }
            },
            error: function(error) {
              toastr["error"](error.message, toastrOptions);
              // Swal.fire('Gagal', 'terjadi kesalahan sistem', 'error');
              console.log(error.XMLHttpRequest);
            }
          });
        }
      });
    });
  </script>
@endpush
