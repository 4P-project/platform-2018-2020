"use strict";
$(document).ready(function () {
    $('#table1').DataTable({
        "scrollX": true,
        "responsive": true
    });
    $('#table2').DataTable({
        "dom": "<'row'<'col-md-5 col-12 float-left'l><'col-md-7 col-12'f>r><'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>", // datatable layout without  horizobtal scroll

    });
    $('#table3').DataTable({
        "dom": "<'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>><'row'<'col-md-5 col-12 float-left'l><'col-md-7 col-12'f>r><'table-responsive't><'row'<'col-md-5 col-12 float-left'l><'col-md-7 col-12 right_search' f>r><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>", // datatable layout without  horizobtal scroll
    });
    $('#table4').DataTable({
        "dom": "<'row'<'col-md-5 col-12 float-left'l><'col-md-7 col-12'f>r><'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>", // datatable layout without  horizobtal scroll
        "responsive": true,
        mark: true
    });
    window.onload = function () {
        $(function () {
            var inputMapper = {
                "name": 1,
                "position": 2,
                "office": 3,
                "age": 4
            };
            var dtInstance = $("#table5").DataTable({
                "lengthMenu": [10, 25, 50, "ALL"],
                bLengthChange: false,
                mark: true
            });
            $("input").on("input", function () {
                var $this = $(this);
                var val = $this.val();
                var key = $this.attr("name");
                dtInstance.columns(inputMapper[key] - 1).search(val).draw();
            });
        });
    }
});
