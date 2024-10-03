<div class="container">
    <!-- Información de la Venta -->
     
    <form>
    <div class="container">
        <div class="row">
            <!-- Vendedor -->
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <label for="vendedor">Vendedor</label>
                    <input type="text" class="form-control" id="vendedor" value="{{ $venta->vendedor->name }}" readonly>
                </div>
            </div>

            <!-- Cliente -->
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <label for="cliente">Cliente</label>
                    <input type="text" class="form-control" id="cliente" value="{{ $venta->user->name }}" readonly>
                </div>
            </div>

            <!-- Monto Total -->
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <label for="monto_total">Monto Total</label>
                    <input type="text" class="form-control" id="monto_total" value="{{ number_format($venta->pago->monto_total, 2) }}" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Monto Neto -->
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <label for="monto_neto">Monto Neto</label>
                    <input type="text" class="form-control" id="monto_neto" value="{{ number_format($venta->pago->monto_neto, 2) }}" readonly>
                </div>
            </div>

            <!-- Estado del Pago -->
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <label for="status_pago">Estado del Pago</label>
                    <input value="{{ $venta->pago->status }}" readonly class="form-control" />
                </div>
            </div>

            <!-- Fecha de Venta -->
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <label for="fecha_venta">Fecha de Venta</label>
                    <input type="text" class="form-control" id="fecha_venta" value="{{ $venta->created_at->format('Y-m-d') }}" readonly>
                </div>
            </div>
        </div>
    </div>
</form>


    <!-- Detalles de Venta -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Detalles de la Venta</h5>
        </div>
        <div class="card-body  table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Impuesto</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($venta->detalleVentas as $detalle)
                    <tr>
                        <td>{{ $detalle->id }}</td>
                        <td>{{ $detalle->producto->nombre }}</td>
                        <td>{{ number_format($detalle->precio_producto, 2) }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>{{ number_format($detalle->neto, 2) }}</td>
                        <td>{{ number_format($detalle->impuesto, 2) }}</td>
                        <td>{{ number_format($detalle->impuesto + $detalle->neto, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pago -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Detalles del Pago</h5>
        </div>
        <div class="card-body  table-responsive">
            <table class="table table-hover ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Monto Total</th>
                        <th>Monto Neto</th>
                        <th>Impuestos</th>
                        <th>Tasa de Dólar</th>
                        <th>Fecha de Pago</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $venta->pago->id }}</td>
                        <td>{{ number_format($venta->pago->monto_total, 2) }}</td>
                        <td>{{ number_format($venta->pago->monto_neto, 2) }}</td>
                        <td>{{ number_format($venta->pago->impuestos, 2) }}</td>
                        <td>{{ number_format($venta->pago->tasa_dolar, 2) }}</td>
                        <td>{{ $venta->pago->fecha_pago }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Método de Pago</h5>
        </div>
        <div class="card-body  table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Método</th> 
                    <th>Banco Origen</th>
                    <th>Banco Destino</th>
                    <th>Número de Referencia</th>
                    <th>Monto BS</th>
                    <th>Monto USD</th>
                </tr>
            </thead>
            <tbody>
                @foreach (json_decode($venta->pago->forma_pago) as $pago)
                    <tr>
                        <td>{{ $pago->metodo }}</td> 
                        <td>{{ $pago->banco_origen }}</td>
                        <td>{{ $pago->banco_destino }}</td>
                        <td>{{ $pago->numero_referencia }}</td>
                        @if($pago->metodo == 'Divisa')
                        <td>{{ number_format(0, 2) }}</td>
                        @else 
                        <td>{{ number_format($pago->monto_bs, 2) }}</td>
                        @endif
                       @if($pago->metodo != 'Divisa')
                       <td>{{ number_format(0, 2) }}</td>
                       @else
                       <td>{{ number_format($pago->monto_dollar, 2) }}</td>
                       @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>
