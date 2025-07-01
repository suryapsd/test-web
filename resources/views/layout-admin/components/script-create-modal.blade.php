<style>
  .modal-backdrop.modal-stack {
    background-color: rgba(0, 0, 0, 0.5) !important;
  }
</style>
<script>
  $('body').on('click', '#{{ $btnNewId }}_new_btn', function() {
    var modal = $('#ajaxModal{{ $modalId }}');
    modal.find('#saveBtn').attr('data-text', 'Create');
    modal.find('#saveBtn').text('Create');
    modal.find('#anotherBtn').remove('d-none');
    modal.find('#titleType').text("Create");

    // Menampilkan modal
    modal.modal('show');
  });

  $(document).on('show.bs.modal', '.modal', function() {
    const $modal = $(this);
    const baseZIndex = 99999;

    modalLevel++;

    // Set z-index modal dan backdrop
    $modal.css('z-index', baseZIndex + (modalLevel * 20));

    setTimeout(function() {
      $('.modal-backdrop').not('.modal-stack')
        .first()
        .addClass('modal-stack')
        .css('z-index', baseZIndex + (modalLevel * 20) - 10);
    }, 0);
  });

  $(document).on('hidden.bs.modal', '.modal', function() {
    modalLevel--;

    // Hapus backdrop stack terakhir
    if ($('.modal:visible').length === 0) {
      $('.modal-backdrop').removeClass('modal-stack').remove();
      modalLevel = 0;
    }
  });

  $('.submitBtn{{ $modalId }}').click(function(e) {
    e.preventDefault();

    // Get the form data
    var submitBtn = $(this);
    var initiate = submitBtn.attr('data-initiate');
    var modalForm = $('#modalForm{{ $modalId }}');

    var formData = new FormData(modalForm[0]);
    formData.append('_method', 'POST');

    $.ajax({
      url: '{{ $modalUrlPost }}',
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
        resetModal('{{ $modalId }}')
        if (initiate === '0') {
          $('#ajaxModal{{ $modalId }}').modal('hide');
        }
        if (data.status) {
          toastr["success"](data.message, toastrOptions);
          @if (isset($params))
            window["{{ $funcDropdown }}"]?.('#{{ $btnNewId }}', data.data.id, '{{ $modalUrlPost . $params }}');
          @else
            window["{{ $funcDropdown }}"]?.('#{{ $btnNewId }}', data.data.id);
          @endif
        } else {
          toastr["warning"](data.message, toastrOptions);
        }
      },
      error: function(data) {
        toastr["error"](data.responseJSON.message, toastrOptions);
        // Error handling for specific input fields
        if (data.status === 422) {
          let errors = data.responseJSON.errors;
          const validModal = $('#ajaxModal{{ $modalId }}');

          // Hapus pesan error dan class is-invalid sebelum menambahkan yang baru
          validModal.find('.is-invalid').removeClass('is-invalid');
          validModal.find('.invalid-feedback').remove();

          $.each(errors, function(key, value) {
            // Tambahkan class is-invalid pada input atau select2
            let input = validModal.find(`#${key}`);
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
</script>
