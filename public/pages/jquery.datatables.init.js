/**
 * Theme: Simple Admin Template
 * Author: Coderthemes
 * Component: Datatable
 */

$('#datatable').dataTable();
$('#datatable-keytable').DataTable({keys: true});
$('#datatable-responsive').DataTable();
$('#datatable-simple').DataTable({
    pageLength: 8,
    lengthMenu: [[5, 8, 15, 20], [5, 8, 15, 20]],
    autoWidth: false,
    searching: false,
    ordering: false,
    bInfo: false,
    language: {
      emptyTable: "Tidak ada Data yang Sesuai dengan Kata Kunci"
    },
    dom: "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-6'i><'col-sm-6'p>>"
});
$('#datatable-ulasan').DataTable({
    pageLength: 3,
    autoWidth: false,
    searching: false,
    ordering: false,
    bInfo: false,
    language: {
      emptyTable: "Tidak ada Ulasan dari Pengguna"
    },
    dom: "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-6'i><'col-sm-6'p>>"
});
$('#datatable-colvid-sorting').DataTable({
    order: [[ 6, "desc" ]],
    "dom": 'C<"clear">lfrtip',
    "colVis": {
        "buttonText": "Atur Kolom"
    }
});
$('#datatable-colvid-sorting-superadmin').DataTable({
    order: [[ 2, "asc" ]],
    "dom": 'C<"clear">lfrtip',
    "colVis": {
        "buttonText": "Atur Kolom"
    }
});
$('#datatable-colvid').DataTable({
    "dom": 'C<"clear">lfrtip',
    "colVis": {
        "buttonText": "Atur Kolom"
    }
});
$('#datatable-scroller').DataTable({
    ajax: "assets/plugins/datatables/json/scroller-demo.json",
    deferRender: true,
    scrollY: 380,
    scrollCollapse: true,
    scroller: true
});
//var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
var table = $('#datatable-fixed-col').DataTable({
    scrollY: "300px",
    scrollX: true,
    scrollCollapse: true,
    paging: false,
    fixedColumns: {
        leftColumns: 1,
        rightColumns: 1
    }
});

var handleDataTableButtons = function () {
        "use strict";
        0 !== $("#datatable-buttons").length && $("#datatable-buttons").DataTable({
            dom: "Bfrtip",
            buttons: [{
                extend: "copy",
                className: "btn-sm"
            }, {
                extend: "csv",
                className: "btn-sm"
            }, {
                extend: "excel",
                className: "btn-sm"
            }, {
                extend: "pdf",
                className: "btn-sm"
            }, {
                extend: "print",
                className: "btn-sm"
            }],
            responsive: !0
        })
    },
    TableManageButtons = function () {
        "use strict";
        return {
            init: function () {
                handleDataTableButtons()
            }
        }
    }();
TableManageButtons.init();