<div id="table-loader" style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1000;">
  <div class="spinner-border text-primary" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
</div>

<script>
  function initCustomDataTable({
    tableId, // ID tabel
    ajaxUrl, // URL untuk request AJAX
    columns, // Kolom tabel sesuai JSON
    extraData = {}, // Data tambahan untuk dikirimkan melalui AJAX
    initCallback = () => {}, // Callback setelah inisialisasi selesai
    initDrawTable = () => {}, // Callback setelah draw table
    options = {}, // Opsi tambahan untuk konfigurasi DataTable
  }) {
    const tableElement = $(tableId);
    const loaderElement = $("#table-loader");
    if (!tableElement.length) return;

    const defaultOptions = {
      ajax: {
        url: ajaxUrl,
        type: "GET",
        dataSrc: "data",
        data: extraData,
      },
      language: {
        lengthMenu: "_MENU_",
        search: "",
        searchPlaceholder: "Search...",
      },
      columns: columns,
      columnDefs: [{
          className: "control text-center",
          targets: 0,
          searchable: false,
          orderable: true,
          render: function(data, type, full, meta) {
            return `<span>${meta.row + 1}</span>`;
          },
        },
        {
          className: "text-center",
          targets: -1,
          render: function(data, type, full, meta) {
            return (
              `<a href="${full.surat_lahir}" target="_blank" class="btn btn-primary">Download</a>`
            );
          },
        },
      ],
      dom: '<"row me-2"' +
        '<"col-md-2"<"me-3"l>>' +
        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"f<"">B>>' +
        '>t' +
        '<"row mx-2"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      initComplete: function(settings, json) {
        initCallback(settings, json);
        $("[data-bs-toggle='tooltip']").tooltip();
      },
    };

    // Gabungkan default options dengan custom options
    const finalOptions = {
      ...defaultOptions,
      ...options
    };

    // Inisialisasi DataTable
    const dataTable = tableElement.DataTable(finalOptions);

    dataTable.on('draw', function() {
      $('[data-bs-toggle="tooltip"]').tooltip();

      var datas = dataTable.rows({
        search: 'applied'
      }).data().toArray();

      initDrawTable(datas);
    });

    // Filter handling
    $('.dataTables_filter').html(
      '<div class="input-group flex-nowrap"><span class="input-group-text" id="addon-wrapping"><i class="tf-icons ti ti-search"></i></span><input type="search" class="form-control form-control-sm" placeholder="Type in to Search" aria-label="Type in to Search" aria-describedby="addon-wrapping"></div>'
    );
    $("#filter-input").on("input", function() {
      dataTable.search(this.value).draw();
    });

    // Event untuk menampilkan loader saat AJAX dimulai
    dataTable.on("processing", function(e, settings, processing) {
      if (processing) {
        loaderElement.show();
      } else {
        loaderElement.hide();
      }
    });

    return dataTable;
  }

  function createButtons(exportOptions) {
    return [{
      extend: 'collection',
      className: 'btn btn-label-primary dropdown-toggle ms-2',
      text: '<i class="ti ti-screen-share me-1 pb-1 ti-xs"></i>Export',
      buttons: exportOptions.map(function(item) {
        return {
          extend: item.extend,
          text: `<i class="ti ti-${item.icon} me-2"></i>${item.name}`,
          className: 'dropdown-item',
          exportOptions: {
            columns: item.columns,
            format: {
              body: function(inner, coldex, rowdex) {
                return item.customFormat ? item.customFormat(inner) : formatExportData(inner);
              }
            }
          }
        };
      })
    }];
  }

  function formatExportData(inner) {
    if (inner.length <= 0) return inner;
    var el = $.parseHTML(inner);
    var result = '';
    $.each(el, function(index, item) {
      if (item.classList !== undefined && item.classList.contains('user-name')) {
        result = result + item.lastChild.firstChild.textContent;
      } else if (item.innerText === undefined) {
        result = result + item.textContent;
      } else result = result + item.innerText;
    });
    return result;
  }
</script>

<script>
  $(document).ready(function() {
    // Definisikan kolom tabel sesuai JSON yang diterima dari server
    const columns = [{
        data: null,
        title: "No"
      },
      {
        data: "name",
        title: "Name"
      },
      {
        data: "position",
        title: "Position"
      },
      {
        data: "office",
        title: "Office"
      },
      {
        data: "salary",
        title: "Salary"
      },
      {
        data: null,
        title: "Action"
      },
    ];

    // Export options
    const exportOptions = createButtons([{
        extend: "excel",
        icon: "file-spreadsheet",
        name: "Excel",
        columns: [0, 1, 2, 3, 4],
      },
      {
        extend: "csv",
        icon: "file-text",
        name: "CSV",
        columns: [0, 1, 2, 3, 4],
      },
    ]);

    // Properti tambahan khusus untuk DataTable ini
    const customOptions = {
      order: [],
      scrollX: true,
      scrollCollapse: true,
      fixedColumns: {
        left: 1,
        right: 1,
      },
      buttons: exportOptions,
    };

    // Inisialisasi DataTable
    const table = initCustomDataTable({
      tableId: "#exampleTable",
      ajaxUrl: "/api/data",
      columns: columns,
      options: customOptions,
      initCallback: function(settings, json) {
        console.log("Table initialized!", json);
      },
    });
  });
</script>
