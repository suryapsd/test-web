@php
  $addNewData = $defaultShowModal ?? true;
@endphp
<script>
  var shouldReload_{{ $tableId }} = @json($reloadPage ?? false);
  @if ($addNewData)
    $('#addNewData{{ $tableId }}').click(function() {
      var modal = $("#ajaxModal{{ $tableId }}");
      modal.find('#modalForm').trigger("reset");

      modal.find('.ckeditor').each(function() {
        let editorId = this.id;
        // console.log(editorId)
        if (editors[editorId]) {
          editors[editorId].setData('');
        }
      });
      if (typeof FilePond !== 'undefined') {
        document.querySelectorAll('.pond').forEach(pond => {
          const filePondInstance = FilePond.find(pond);
          if (filePondInstance) {
            filePondInstance.removeFiles();
          }
        });
      }

      modal.find('#data_id').val('');
      modal.find('#titleType').text('Create');
      modal.find('#saveBtn').text('Create');
      modal.find('#saveBtn').attr('data-text', 'Create');
      modal.find('#anotherBtn').removeClass('d-none');
      modal.modal('show');
      if (modal.find('#user-account').length > 0) {
        modal.find('#user-account').removeClass('d-none');
      }
    });
  @endif

  // Function to reset form and remove errors when modal is closed
  $("#ajaxModal{{ $tableId }}").on("hidden.bs.modal", function() {
    resetModal('{{ $tableId }}')
  });

  function resetModal(tableId) {
    var modalForm = $('#modalForm' + tableId);
    modalForm.trigger("reset");

    if (modalForm.find('.select2default')) {
      modalForm.find('.select2default').val(null).trigger('change');
    }
    if (modalForm.find('.select2Icons')) {
      modalForm.find('.select2Icons').val(null).trigger('change');
    }
    if (typeof FilePond !== 'undefined') {
      document.querySelectorAll('.pond').forEach(pond => {
        const filePondInstance = FilePond.find(pond);
        if (filePondInstance) {
          filePondInstance.removeFiles();
        }
      });
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

  $('.submitBtn{{ $tableId }}').click(function(e) {
    e.preventDefault();

    // Get the form data
    var submitBtn = $(this);
    var initiate = submitBtn.attr('data-initiate');
    var modalForm = $('#modalForm{{ $tableId }}');

    modalForm.find(".ckeditor").each(function() {
      let editorId = this.id;
      if (editors[editorId]) {
        $(this).val(editors[editorId].getData());
      }
    });

    var formData = new FormData(modalForm[0]);
    formData.append('_method', 'POST');

    $.ajax({
      url: '{{ $urlPost }}',
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
        resetModal('{{ $tableId }}')
        if (initiate === '0') {
          $('#ajaxModal{{ $tableId }}').modal('hide');
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
          table_{{ $tableId }}.ajax.reload();
          if (shouldReload_{{ $tableId }}) {
            window.location.reload();
          }
        } else {
          toastr["warning"](data.message, toastrOptions);
        }
      },
      error: function(data) {
        toastr["error"](data.responseJSON.message, toastrOptions);
        // Error handling for specific input fields
        if (data.status === 422) {
          let errors = data.responseJSON.errors;

          // Hapus pesan error dan class is-invalid sebelum menambahkan yang baru
          $('.is-invalid').removeClass('is-invalid');
          $('.invalid-feedback').remove();

          $.each(errors, function(key, value) {
            // Tambahkan class is-invalid pada input atau select2
            let input;
            if (key.includes('.')) {
              let keyTemp = convertDotNotationToArrayNotation(key);
              input = $(`#${keyTemp[0]}\\[${keyTemp[1]}\\]\\[${keyTemp[2]}\\]`);
            } else {
              input = $(`#${key}`);
            }
            input.addClass('is-invalid');

            if (input.hasClass('select2-hidden-accessible')) {
              // Ambil wrapper .input-group dari elemen select
              let inputGroup = input.closest('.input-group');
              inputGroup.after(`<div class="invalid-feedback d-block">${value[0]}</div>`);

            } else if (input.hasClass('ckeditor')) {
              // Jika input adalah elemen ckeditor
              let ckeditor = input.next('.ck-editor');
              ckeditor.after(`<div class="invalid-feedback">${value[0]}</div>`);

            } else {
              // Cari apakah input memiliki ikon dalam satu group
              let icon = input.next('.input-group-text');

              // Jika ada ikon, tambahkan pesan error setelah ikon
              if (icon.length) {
                if (icon.next('.invalid-feedback').length === 0) {
                  icon.after(`<div class="invalid-feedback">${value[0]}</div>`);
                }
              } else {
                // Jika tidak ada ikon, tambahkan langsung setelah input
                if (input.next('.invalid-feedback').length === 0) {
                  input.after(`<div class="invalid-feedback">${value[0]}</div>`);
                }
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

  function convertDotNotationToArrayNotation(input) {
    if (!input.includes('.')) return input;
    return input.split('.');
  }

  // Function to delete data
  $('body').on('click', '.deleteData{{ $tableId }}', function() {
    var data = $(this).data('json');
    Swal.fire({
      icon: 'warning',
      // title: 'Warning',
      text: 'Delete data {{ $title ?? '' }} ' + (data.name || data.title || data.service_name || data.villa_name || data.booking_by || '') + '?',
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
          url: '{{ $urlPost }}/' + data.id,
          type: "DELETE",
          dataType: "JSON",
          success: function(data) {
            if (data.status) {
              toastr["success"](data.message, toastrOptions);
              // Swal.fire('Sukses', data.message, 'success');
              // Reload the DataTable after successful deletion
              table_{{ $tableId }}.ajax.reload();
              if (shouldReload_{{ $tableId }}) {
                window.location.reload();
              }
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
