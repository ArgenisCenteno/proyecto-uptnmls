<div class="table-responsive">
    <table class="table table-hover" id="ventas-table">
        <thead class="bg-light">
            <tr>
                <th>#</th>
                 
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Monto Neto</th>
                <th>Monto Total</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>


</div>

@section('js')
@include('layout.script')
<script src="{{ asset('js/adminlte.js') }}"></script>
<script src="{{asset('js/sweetalert2.js')}}"></script>

<script type="text/javascript">
   $(document).ready(function() {
        $('#ventas-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('ventas.index') }}",
            dataType: 'json',
            type: "POST",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'user', name: 'user' },
                { data: 'vendedor', name: 'vendedor' },
                { data: 'monto_neto', name: 'monto_neto' },
                { data: 'monto_total', name: 'monto_total' },
                { data: 'fecha', name: 'fecha' },
                { data: 'status', name: 'status' },
                { data: 'actions', name: 'actions', searchable: false, orderable: false }
            ],
            order: [[0, 'desc']],
            language: {
                lengthMenu: "Mostrar _MENU_ Registros por Página",
                zeroRecords: "Sin resultados",
                info: "",
                infoEmpty: "No hay Registros Disponibles",
                infoFiltered: "Filtrado _TOTAL_ de _MAX_ Registros Totales",
                search: "Buscar",
                paginate: {
                    next: ">",
                    previous: "<"
                }
            }
        });

        // Manejar el evento submit del formulario de eliminación
        $('.btn-delete').on('submit', function(e) {
            e.preventDefault(); // Evita el envío del formulario por defecto

            var form = $(this); // Obtiene el formulario actual

            Swal.fire({
                title: '¿Está seguro?',
                text: "El registro se eliminará permanentemente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.off('submit').submit(); // Permite el envío del formulario si se confirma
                }
            });
        });
    });
</script>
 
@endsection