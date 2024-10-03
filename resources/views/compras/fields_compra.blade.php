<form action="{{ route('compras.generarCompra') }}" method="POST">
    @csrf <!-- Agrega el token CSRF para seguridad -->
    <section>
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div class="d-flex flex-row align-items-center">
                <h4 class="text-uppercase mt-1">Información de Pago</h4>
                <span class="ms-2 me-3"></span>
            </div>

        </div>

        <div class="productoCarrito" id="productoCarrito">

        </div>
        <div class="text-center mt-4">
            <h5>Total a Pagar: <span id="totalVenta" class="totalVenta">$0.00</span></h5>
            <h5>Cancelado: <span id="cancelado" class="cancelado">$0.00</span></h5>
            <h5>Restante: <span id="restante" class="restante">$0.00</span></h5>
            <input type="hidden" name="productos" id="productosInput">
            <input type="hidden" name="metodos_pago" id="metodosPagoInput">
        </div>
        <hr />


        <div class="d-flex flex-column mb-3">
            <div data-mdb-ripple-init class="btn-group-vertical" role="group" aria-label="Vertical button group">

                <label data-mdb-ripple-init class="btn btn-outline-primary btn-lg" for="option1">
                    <div class="d-flex justify-content-between">
                        <span>Caja </span>
                        <input type="hidden" name="id_caja" value="{{$caja->id}}">
                        <span>{{$caja->nombre}}</span>
                    </div>
                </label>

                <label data-mdb-ripple-init class="btn btn-outline-primary btn-lg" for="option1">
                    <div class="d-flex justify-content-between">
                        <span>Tasa de cambio </span>
                        <input type="hidden" name="tasa" id="tasa" value="{{$dollar->valor}}">
                        <input type="hidden" name="id_tasa" value="{{$dollar->id}}">
                        <span>{{$dollar->valor}}</span>
                    </div>
                </label>

                <input type="radio" data-mdb-ripple-init class="btn-check" name="options" id="option2"
                    autocomplete="off" checked />
                <label data-mdb-ripple-init class="btn btn-outline-primary btn-lg" for="option2">
                    <div class="d-flex justify-content-between">
                        <span>Vendedor </span>
                        <span>{{auth()->user()->name}}</span>
                    </div>
                </label>
                <h4>Proveedor</h4>
                <select name="user_id" id="user_id" class="form-control select2 mb-2 mt-2">
                <option value="">Seleccione una opción</option>
                    @foreach($users as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>


            </div>
            <div id="metodosPagoContainer">
                <h4>Métodos de Pago</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <select class="form-select" id="metodoPago">
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia">Transferencia</option>
                            <option value="Pago Movil">Pago Móvil</option>
                            <option value="Divisa">Divisa</option>
                            <option value="Punto de Venta">Punto de Venta</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="number" class="form-control" id="cantidadPagada" placeholder="Cantidad ">
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="bancoOrigen" placeholder="Banco Origen (Opcional)">
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="bancoDestino"
                            placeholder="Banco Destino (Opcional)">
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="numeroReferencia"
                            placeholder=" Referencia (Opcional)">
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-success w-100" id="agregarMetodoPago">Agregar
                            Método</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="metodosPagoList"></div>


        <button type="submit" id="submitBtn" class="btn btn-primary" disabled>Generar Venta</button>
        </div>

    </section>

</form>