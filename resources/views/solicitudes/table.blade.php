<div class="table-responsive">
    <table class="table table-hover" id="categorias-table">
        <thead class="bg-light">
            <tr >
                <th >#</th>
                <th>Fecha</th>
                <th>Descripción</th>
                <th>Financiamiento</th>
                <th>Proveedor</th>
                <th>Creado por</th>
                <th>Estado</th>
                <th>Tramite</th>
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
            ajax: "{{route('solicitudes.index')}}",
            dataType: 'json',
            type: "POST",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'fecha',
                    name: 'fecha',
                },
                {
                    data: 'descripcion',
                    name: 'descripcion',
                },
                {
                    data: 'financiamiento',
                    name: 'financiamiento',
                },
                {
                    data: 'proveedor',
                    name: 'proveedor',
                },

                {
                    data: 'usuario',
                    name: 'usuario',
                },
                {
                    data: 'status',
                    name: 'status',
                },
                {
                    data: 'tramite',
                    name: 'tramite',
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
