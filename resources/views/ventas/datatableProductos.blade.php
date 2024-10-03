<div class="table-responsive">
    <table class="table table-hover" id="productos-table2">
        <thead class="bg-light">
            <tr>

                <th>Nombre</th>
                <th>Precio</th>
                <th> IVA</th>
                <th>Stock</th>
                <th>Subcategoría</th>
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
<script src="{{asset('js/sweetalert2.js')}}"></script>
<script type="text/javascript">

    $(document).ready(function () {
        let productosEnCarrito = [];


        $('#productos-table2').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('ventas.datatableProductoVenta') }}",
            dataType: 'json',
            type: "POST",
            columns: [
                { data: 'nombre', name: 'nombre' },
                { data: 'precio_venta', name: 'precio_venta' },
                {
                    data: 'aplica_iva', name: 'aplica_iva', render: function (data) {
                        return data ? 'Sí' : 'No';
                    }
                },
                { data: 'cantidad', name: 'cantidad' },
                { data: 'subCategoria', name: 'subCategoria' },
                {
                    data: 'id',
                    name: 'actions',
                    searchable: false,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        return '<button type="button" class="btn btn-info addToCartBtn" data-product-id="' + data + '">Agregar al Carrito</button>';
                    }
                }
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

        $(document).on('click', '.addToCartBtn', function () {
            const productId = $(this).data('product-id');
            const url = '{{ route('productos.obtener', ['id' => ':id']) }}';
            const urlWithId = url.replace(':id', productId);
            const $button = $(this);

            $.ajax({
                url: urlWithId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        const producto = response.producto;

                        if (producto.cantidad == 0 || producto.cantidad < 0) {
                            Swal.fire({
                                title: 'Sin stock',
                                text: "Este producto no está disponible.",
                                icon: 'info',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33'
                            })
                            return;
                        }

                        const productName = producto.nombre;
                        const productPrice = producto.precio_venta;
                        const productIva = producto.aplica_iva ? 'Sí' : 'No';
                        var precioProductoIva = producto.precio_venta;
                        if (productIva == 'Sí') {
                            var precioProductoIva = productPrice * 1.16;
                        } else {
                            var precioProductoIva = productPrice;
                        }
                        const productDescription = producto.descripcion;
                        const productLote = producto.lote;
                        const productoStock = producto.cantidad;
                        const productSubcategoria = producto.subCategoria ? producto.subCategoria.nombre : '';

                        // Agregar el producto al array
                        productosEnCarrito.push({
                            id: productId,
                            nombre: productName,
                            precio: productPrice,
                            aplicaIva: producto.aplica_iva,
                            cantidad: 1 // Cantidad inicial
                        });
                        const productoHTML = `
    <div class="productoCarrito mb-3" id="productoCarrito_${productId}">
        <h5 class="mb-0 ">Bs ${precioProductoIva}</h5>
        <h5 class="mb-3 nombreProducto">${productName}</h5>
        <div>
            <div class="d-flex justify-content-between">
                <div class="d-flex flex-row mt-1">
                    <h6>Precio bruto:</h6>
                    <h6 class="fw-bold text-success ms-1 precioProducto" id="precioProducto_${productId}">Bs${productPrice}</h6>
                </div>
                <div class="d-flex flex-row align-items-center text-primary">
                    <span class="ms-1 aplicaIVA" id="aplicaIVA_${productId}"> ${productIva}</span>
                </div>
            </div>
          
              <h6>Descripción:</h6> <p>${productDescription}</p>
              
            <div class="p-2 d-flex justify-content-between align-items-center bg-body-tertiary">
                <span id="productLote_${productId}">Lote: ${productLote}</span>
               
            </div>
            <hr />
           <div class="d-flex mb-3">
                <div class="input-group me-2">
                    <span class="input-group-text">Cantidad:</span>
                    <input type="number" class="form-control cantidadProducto" value="1" min="1" id="cantidadProducto_${productId}">
                    <input type="hidden" class="stock" id="stock_${productId}" value="${productoStock}"/>
                </div>
                <button type="button" class="btn btn-danger removeProducto" id="removeProducto_${productId}">Eliminar</button>
            </div>
        </div>
    </div>
`;

                        // Agregar el productoHTML al contenedor #productoCarrito
                        $('#productoCarrito').append(productoHTML);
                        $button.prop('disabled', true);

                        // Calcular el total a pagar
                        calcularTotal();
                        actualizarProductosInput();
                    } else {
                        console.error('Error: No se pudo obtener el producto.');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error al obtener el producto:', error);
                }
            });
        });

        $(document).on('click', '.removeProducto', function () {
            const productId = $(this).attr('id').split('_')[1];
            $('#productoCarrito_' + productId).remove();
            const $button = $(this);

            // Eliminar el producto del array
            productosEnCarrito = productosEnCarrito.filter(function (producto) {
                return producto.id != productId;
            });
            $('.addToCartBtn[data-product-id="' + productId + '"]').prop('disabled', false);
            calcularTotal();
            actualizarProductosInput();
        });

        $(document).on('change', '.cantidadProducto', function () {
            const productId = $(this).attr('id').split('_')[1]; // Obtener el ID del producto
            const nuevaCantidad = parseInt($(this).val());
            const stockDisponible = parseInt($(`#stock_${productId}`).val()); // Obtener el stock disponible
            if (nuevaCantidad > stockDisponible) {
                Swal.fire({
                    title: 'Sin stock',
                    text: "Cantidad ingresada supera el stock.",
                    icon: 'info',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33'
                })
                $(this).val(stockDisponible);
            }

            // Actualizar la cantidad en el array
            productosEnCarrito = productosEnCarrito.map(function (producto) {
                if (producto.id == productId) {
                    producto.cantidad = nuevaCantidad;
                }
                return producto;
            });

            // Recalcular el total
            calcularTotal();
            actualizarProductosInput();
        });
        // Función para calcular el total de la venta
        function calcularTotal() {
            let total = 0;

            // Iterar sobre cada producto en el carrito
            $('.productoCarrito').each(function () {
                const productId = $(this).attr('id').split('_')[1];

                if (productId != undefined) {

                    const precioProducto = parseFloat($('#precioProducto_' + productId).text().replace('Bs', ''));

                    const cantidad = parseInt($('#cantidadProducto_' + productId).val());
                    const aplicaIva = $('#aplicaIVA_' + productId).text().trim() === 'Sí';

                    let subtotalProducto = precioProducto * cantidad;

                    // Aplicar el IVA si corresponde
                    if (aplicaIva) {
                        subtotalProducto *= 1.16; // 16% de IVA
                    }

                    total += subtotalProducto;

                }
            });



            // Mostrar el total calculado
            $('.totalVenta').text('$' + total.toFixed(2));

        }

        function actualizarProductosInput() {
            $('#productosInput').val(JSON.stringify(productosEnCarrito));
        }
    });


    let metodosPago = [];


    calcularTotalPagos();

    const tasaCambio = parseFloat($('#tasa').val());

    $('#agregarMetodoPago').on('click', function () {
        const metodoPago = $('#metodoPago').val();
        let cantidadPagada = parseFloat($('#cantidadPagada').val());
        const bancoOrigen = $('#bancoOrigen').val();
        const bancoDestino = $('#bancoDestino').val();
        const numeroReferencia = $('#numeroReferencia').val();

        let montoBs = cantidadPagada;
        let montoDollar = cantidadPagada / tasaCambio;
        // Validar cantidad pagada
        if (isNaN(cantidadPagada) || cantidadPagada <= 0) {
            alert('Por favor, ingresa una cantidad pagada válida.');
            return;
        }

        // Convertir divisa a bolívares si el método de pago es divisa
        if (metodoPago === 'Divisa') {
            montoBs = cantidadPagada * tasaCambio;
            montoDollar = cantidadPagada;
        }


        let totalVenta = parseFloat($('#totalVenta').text().replace('$', ''));
        let cancelado = parseFloat($('#cancelado').text().replace('$', ''));

        if (cancelado + montoBs > totalVenta) {
            $('#advertencia').show();
        } else if (cancelado + montoBs <= totalVenta) {
            $('#advertencia').hide();
            cancelado += montoBs;

            const metodo = {
                metodo: metodoPago,
                cantidad: cantidadPagada,
                banco_origen: bancoOrigen,
                banco_destino: bancoDestino,
                numero_referencia: numeroReferencia,
                monto_bs: montoBs,
                monto_dollar: montoDollar
            };

            metodosPago.push(metodo);
            $('#cancelado').text('$' + cancelado.toFixed(2));

            // Check if total is paid
            if (cancelado >= totalVenta) {
                $('#submitBtn').prop('disabled', false);
            } else {
                $('#submitBtn').prop('disabled', true);
            }
        }

        actualizarMetodosPago();
        calcularTotalPagos();

        // Limpiar campos
        $('#cantidadPagada').val('');
        $('#bancoOrigen').val('');
        $('#bancoDestino').val('');
        $('#numeroReferencia').val('');
    });
    // Eliminar Método de Pago
    $(document).on('click', '.removeMetodoPago', function () {
        const index = $(this).data('index');
        metodosPago.splice(index, 1);
        actualizarMetodosPago();
        calcularTotalPagos();
    });

    // Actualizar lista de métodos de pago en el DOM
    function actualizarMetodosPago() {
        let html = '';
        metodosPago.forEach((metodo, index) => {
            html += `
            <div class="mb-2 metodoPagoItem mt-3" style='space-around'>
                <span>${metodo.metodo} - $${metodo.monto_dollar.toFixed(2)} (${metodo.monto_bs.toFixed(2)} Bs) ${metodo.banco_origen ? ' | Origen: ' + metodo.banco_origen : ''} ${metodo.banco_destino ? ' | Destino: ' + metodo.banco_destino : ''} ${metodo.numero_referencia ? ' | Ref: ' + metodo.numero_referencia : ''}</span>
                <button type="button" class="btn btn-danger btn-sm removeMetodoPago" data-index="${index}">Eliminar</button>
        `;
        });
        $('#metodosPagoList').html(html);
        $('#metodosPagoInput').val(JSON.stringify(metodosPago));
    }

    // Calcular y actualizar total a pagar y total cancelado
    function calcularTotalPagos() {
        totalPagar = 0;
        totalCancelado = 0;


        // Si el método de pago es divisa, aplicar la tasa de cambio al monto_bs
        metodosPago.forEach(metodo => {


            // Si el método de pago es divisa, aplicar la tasa de cambio al monto_bs
            if (metodo.metodo === 'Divisa') {
                totalCancelado += metodo.cantidad * tasaCambio;
            } else {
                totalCancelado += metodo.monto_bs;
            }
        });

        // Actualizar en el DOM
        let totalVenta = parseFloat($('#totalVenta').text().replace('$', ''));
        $('#cancelado').text('$' + totalCancelado.toFixed(2));
        $('#restante').text((totalCancelado - totalVenta).toFixed(2));


        // Habilitar o deshabilitar botón submit según el total pagado
        validarTotalPagado();
    }

    // Validar el total pagado y habilitar/deshabilitar botón submit
    function validarTotalPagado() {
        const tasa = parseFloat($('#tasa').val()) || 1; // Obtener la tasa de cambio (por defecto 1 si está vacío)
        const totalPagadoBs = totalCancelado * tasa;

        if (totalPagadoBs >= totalPagar) {
            $('#btnSubmit').prop('disabled', false).removeClass('btn-danger').addClass('btn-primary');
        } else {
            $('#btnSubmit').prop('disabled', true).removeClass('btn-primary').addClass('btn-danger');
            alert('El monto pagado no puede ser menor al total a pagar en bolívares.');
        }
    }

    // Evento cambio en la tasa de cambio
    $('#tasa').on('input', function () {
        tasaCambio = parseFloat($(this).val()) || 1; // Actualizar la tasa de cambio
        calcularTotalPagos(); // Recalcular total con la nueva tasa de cambio
    });

    // Envío del formulario
    $('#ventaForm').on('submit', function (event) {
        event.preventDefault();

        // Validar una última vez antes de enviar
        if (totalPagar <= 0 || totalCancelado < totalPagar) {
            alert('Aún no se ha pagado el total requerido.');
            return;
        }

        // Aquí puedes enviar el formulario al controlador
        // Implementa tu lógica para enviar los datos al servidor
        alert('Formulario enviado correctamente.');
        // this.submit(); // Descomenta esta línea para enviar el formulario realmente
    });
</script>

@endsection