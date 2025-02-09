<div class="table-responsive">
<div class="table-responsive">
    <table class="table table-hover" id="productos-table">
        <thead class="bg-light">
            <tr>
                <th> Producto</th>
                <th>Cantidad </th>
                <th>Estado</th>
                <th>Unidad de Medida</th>
                <th>Personal</th>
                <th>Fecha de Entrega</th>
                <th>Fecha de Devolución</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

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
            ajax: "{{ route('productosPendientes') }}", 
            type: "POST",
            columns: [
                { data: 'nombre_producto', name: 'nombre_producto' },
                { data: 'cantidad_asignada', name: 'cantidad_asignada' },
                { data: 'estado', name: 'estado' },
                { data: 'unidad_medida', name: 'unidad_medida' },
                { data: 'personal', name: 'personal' },
                { data: 'created_at', name: 'created_at' },
                { data: 'fecha_devolucion', name: 'fecha_devolucion' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            order: [[4, 'desc']], // Ordena por fecha de creación
            language: {
                lengthMenu: "Mostrar _MENU_ Registros por Página",
                zeroRecords: "Sin resultados",
                info: "Mostrando página _PAGE_ de _PAGES_",
                infoEmpty: "No hay Registros Disponibles",
                infoFiltered: "Filtrado de _TOTAL_ de _MAX_ Registros Totales",
                search: "Buscar",
                paginate: {
                    next: ">",
                    previous: "<"
                }
            }
        });
    });
</script>
@endsection


