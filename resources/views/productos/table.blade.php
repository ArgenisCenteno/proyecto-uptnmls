<div class="table-responsive">
    <table class="table table-hover" id="productos-table">
        <thead class="bg-light">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Stock</th>
                <th>Subcategoría</th>
                <th>Disponible</th>
                <th>Unidad de Medida</th>
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
            ajax: "{{ route('inventario') }}", 
            dataType: 'json',
            type: "POST",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nombre', name: 'nombre' },
                { data: 'descripcion', name: 'descripcion' },
                { data: 'cantidad', name: 'cantidad' },
                { data: 'subCategoria', name: 'subCategoria' }, 
                { data: 'disponible', name: 'disponible' },
                { data: 'unidad_medida', name: 'unidad_medida' },
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

