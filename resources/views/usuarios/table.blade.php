<div class="table-responsive">
    <table class="table table-hover" id="productos-table">
        <thead class="bg-light">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Cédula</th>
                <th>Telefono</th>
                <th>Fecha</th>
                <th>Estado</th>
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

        $('#productos-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('usuarios.index') }}", 
            dataType: 'json',
            type: "POST",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'cedula', name: 'cedula' },
                { data: 'telefono', name: 'telefono' },
                { data: 'fecha', name: 'fecha' },
                { data: 'estado', name: 'estado' },
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

