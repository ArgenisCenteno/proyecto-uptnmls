<div class="table-responsive">
    <table class="table table-hover" id="categorias-table">
        <thead class="bg-light">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Estatus</th>
                <th>Fecha Creación</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>

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
            ajax: "{{route('cajas.index')}}",
            dataType: 'json',
            type: "POST",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'nombre',
                    name: 'nombre',
                },
                {
                    data: 'status',
                    name: 'sstatus',
                },

                {
                    data: 'created_at',
                    name: 'created_at',
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
