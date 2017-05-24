<script src="/js/dataTables.buttons.min.js"></script>
<script src="/js/jszip.min.js"></script>
<script src="/js/pdfmake.min.js"></script>
<script src="/js/vfs_fonts.js"></script>
<script src="/js/buttons.html5.min.js"></script>
<script src="/js/jquery.debounce.min.js"></script>
<script>
    var dtbl = $('#{{ $table_id }}').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        fixedColumns: true,
        ajax: '{{ route($route) }}',
        {!! $columns !!}
        dom: 'Blfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                $(column.footer()).children(0)
                    .keyup($.debounce( 500, function (){
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val ? val : '', true, false).draw();
                    }));
            });
        }
    });
</script>