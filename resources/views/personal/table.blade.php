<div class="table-responsive">
    <table class="table table-hover" id="personal-table">
        <thead class="bg-light">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Rif</th>
                <th>Telefono</th>
                <th>Dirección</th>
                <th>Estado</th>
                <th>Area</th>
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

        $('#personal-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('personal.index') }}", 
            dataType: 'json',
            type: "POST",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nombre', name: 'nombre' },
                { data: 'rif', name: 'rif' },
                { data: 'telefono', name: 'telefono' },
                { data: 'direccion', name: 'direccion' },
                { data: 'estado', name: 'estado' },
                { data: 'area', name: 'area' },
             
                { data: 'actions', name: 'actions', searchable: true, orderable: true }
            ],
            order: [[0, 'desc']],
            "language": {
                "lengthMenu": "Mostrar _MENU_ Registros por Página",
                "zeroRecords": "Sin resultados",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay Registros Disponibles",
                "infoFiltered": "Filtrado de _TOTAL_ de _MAX_ Registros Totales",
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

