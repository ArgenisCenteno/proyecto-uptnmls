<div class="table-responsive">
    <table class="table table-hover" id="categorias-table">
        <thead class="bg-light">
            <tr >
                <th >#</th>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Creado por</th>
                <th>Estado</th>
                <th>Fecha</th>
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
            ajax: "{{route('tramites.index')}}",
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
                    data: 'usuario',
                    name: 'usuario',
                },
                {
                    data: 'estado',
                    name: 'estado',
                },

                {
                    data: 'fecha',
                    name: 'fecha',
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
