<div class="table-responsive">
    <table class="table table-hover" id="categorias-table">
        <thead class="bg-light">
            <tr >
                <th >#</th>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Uso</th>
                <th>Creado por</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody class="text-center">

        </tbody>
    </table>


</div>

@section('js')
@include('layout.script')
<script src="{{ asset('js/adminlte.js') }}"></script>

<script type="text/javascript">
   $(document).ready(function() {

    $('#categorias-table').DataTable({
        processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{route('requerimientos.index')}}",
            dataType: 'json',
            type: "POST",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'tipo',
                    name: 'tipo',
                },
                {
                    data: 'descripcion',
                    name: 'descripcion',
                },
                {
                    data: 'uso',
                    name: 'uso',
                },
                {
                    data: 'usuario',
                    name: 'usuario',
                },

                {
                    data: 'fecha',
                    name: 'fecha',
                },
                {
                    data: 'status',
                    name: 'status',
                },

                {
                    data: 'actions',
                    name: 'actions',
                    searchable: false,
                    orderable: false
                }
            ],
        order: [
            [0, 'desc']
        ],
        "language": {
            "lengthMenu": "Mostrar _MENU_ Registro por Página",
            "zeroRecords": "Sin resultado",
            "info": "",
            "infoEmpty": "No hay Registros Disponibles",
            "infoFiltered": "filtrado _TOTAL_ de _MAX_ Registros Totales",
            "search": "Buscar",
            "paginate": {
                "next": ">",
                "previous": "<"
            }
        }
    });
});
</script>

@endsection
