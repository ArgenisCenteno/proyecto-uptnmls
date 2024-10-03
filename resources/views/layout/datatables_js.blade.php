<!-- Datatables -->
<script type="text/javascript" src="{{asset('js/pdfmake.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/vfs_fonts.js')}}"></script>
<script type="text/javascript" src="{{asset('js/datatables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-table.min.js')}}"></script>

<script>
    $(function() {
        const languages = {
            'es': '{{asset('js/Spanish.json')}}'
        };

        $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, {
            className: 'btn btn-sm'
        })
        $.extend(true, $.fn.dataTable.defaults, {
            responsive: true,
            language: {
                url: languages['es']
            },
            pageLength: 25,
            dom: 'lBfrtip',
            buttons: [{
                    extend: 'copy',
                    className: 'btn-light',
                    text: 'Copiar',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    className: 'btn-light',
                    text: 'CSV',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn-light',
                    text: 'Excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn-light',
                    text: 'PDF',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    className: 'btn-light',
                    text: 'Imprimir',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'colvis',
                    className: 'btn-light',
                    text: 'Visibilidad Columnas',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ]
        });
    });
</script>
