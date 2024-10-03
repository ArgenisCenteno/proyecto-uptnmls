<div class="row">
    <div class="col-md-6">
        <label for=""><strong>Buscar Producto</strong></label>
        <input type="text" id="buscador" placeholder="Buscar producto..." class="form-control">
    </div>

    <div class="col-md-6 mt-2">  
        <label for=""><strong>Resultados de Búsqueda</strong></label>
        <div id="listaProductos"></div>
    </div>

    <div class="col-md-6 mt-4">
        {!! Form::label('proveedor', 'Proveedor:', ['class' => 'bold']) !!}
        {!! Form::select('proveedor', $proveedores->pluck('razon_social', 'id'), $solicitud->proveedor_id, ['class' => 'form-control round']) !!}
    </div>

    <div class="col-md-6 mt-4">
        {!! Form::label('financiamiento', 'Financiamiento:', ['class' => 'bold']) !!}
        {!! Form::select('financiamiento', [
            'Ingresos Propios' => 'Ingresos Propios',
            'Otros' => 'Otros',
        ], $solicitud->financiamiento, ['class' => 'form-control round']) !!}
    </div>

    <div class="col-md-6 mt-4">
        {!! Form::label('requerimiento', 'Requerimiento:', ['class' => 'bold']) !!}
        {!! Form::select('requerimiento', $requerimientos->pluck('id', 'id'), $solicitud->requerimiento_id, ['class' => 'form-control round']) !!}
    </div>

    <div class="col-md-12 mt-4">
        <label for=""><strong>Productos Seleccionados</strong></label>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                <tr>
                    <td>{{ $producto->producto->nombre }}</td>
                    <td>{{ $producto->producto->descripcion }}</td>
                    <td>
                        <input type="number" name="cantidad[{{ $producto->id }}]" value="{{ $producto->cantidad }}" class="form-control">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-eliminar" data-id="{{ $producto->id }}">Eliminar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="col-md-6"></div>

    <div class="col-md-6">
        <div class="float-end">
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary round']) !!}
            <a href="{{ route('solicitudes.index') }}" class="btn btn-danger">Cancelar</a>
        </div>
    </div>
</div>

<script src="{{asset('js/sweetalert2.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#buscador').on('input', function () {
            const query = $(this).val();

            if (query.length >= 4) { // Asegúrate de que haya al menos 3 caracteres
                $.ajax({
                    url: '/buscarProductos', // Asegúrate de que esta URL sea correcta
                    method: 'GET',
                    data: { q: query },
                    dataType: 'json',
                    success: function (data) {
                        // Limpiar la lista de productos
                        $('#listaProductos').empty();

                        // Comprobar si hay resultados
                        if (data.length > 0) {
                            $.each(data, function (index, item) {
                                $('#listaProductos').append(
                                    `<div class="producto-item card p-2 bg-secondary text-white" data-id="${item.id}" data-descripcion="${item.descripcion}" data-stock="${item.cantidad}">${item.nombre}</div>`
                                );
                            });
                        } else {
                            $('#listaProductos').append('<div>No se encontraron productos.</div>');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error en la búsqueda:', error);
                    }
                });
            } else {
                $('#listaProductos').empty(); // Limpiar la lista si menos de 3 caracteres
            }
        });

        // Manejar el clic en un elemento de la lista
        $(document).on('click', '.producto-item', function () {
            const productoId = $(this).data('id');
            const productoDescripcion = $(this).data('descripcion');
            const productoNombre = $(this).text();

            // Comprobar si el producto ya existe en la tabla
            const existeProducto = $('.table tbody tr').filter(function () {
                return $(this).find('td').first().text() === productoNombre; // Compara el nombre del producto
            }).length > 0;

            if (existeProducto) {
                Swal.fire({
                    title: 'Advertencia',
                    text: "Ese producto ya fue agregado a la tabla.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'rgba(13, 172, 85)',
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar'
                })
                return; // Salir de la función si el producto ya existe
            }

            // Agregar el producto a la tabla
            const nuevaFila = `
        <tr>
            <td>${productoNombre}</td>
            <td>${productoDescripcion}</td>
            <td><input type="number" class="form-control" step="any"  /></td>
            <td>
                <button class="btn btn-danger btn-eliminar" data-id="${productoId}">Eliminar</button>
            </td>
        </tr>
    `;

            // Append the new row to the table
            $('.table tbody').append(nuevaFila);
        });


        $(document).on('click', '.btn-eliminar', function () {

            Swal.fire({
                    title: 'Advertencia',
                    text: "¿Desea eliminar este producto?.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'rgba(13, 172, 85)',
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar'
        }).then((result) => {
            if(result.isConfirmed){
                $(this).closest('tr').remove(); // Elimina la fila correspondiente
            }
        }

        )
        });

        $('#formularioSolicitud2').on('submit', function (event) {
            // Prevenir el envío por defecto del formulario
            event.preventDefault();

            // Limpiar campos ocultos anteriores
            $(this).find('input[name^="productos"]').remove();


            $('.table tbody tr').each(function () {
                const nombre = $(this).find('td').eq(0).text();
                const descripcion = $(this).find('td').eq(1).text();
                const cantidad = $(this).find('input').val();

          //      console.log(nombre, descripcion, cantidad)

                $('<input>').attr({
                    type: 'hidden',
                    name: 'productos[]',
                    value: JSON.stringify({
                        nombre: nombre,
                        descripcion: descripcion,
                        cantidad: cantidad,
                })
                }).appendTo(this);
            });

            // Ahora se puede enviar el formulario
            this.submit();
        });

    });
</script>