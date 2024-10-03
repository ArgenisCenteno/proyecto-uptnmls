

        <!-- Mostrar detalles del trámite -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tipo">Tipo de Trámite</label>
                    <input type="text" class="form-control" id="tipo" value="{{ $tramite->tipo }}" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="id_tramite">ID del Trámite</label>
                    <input type="text" class="form-control" id="id_tramite" value="{{ $tramite->id }}" disabled>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="status_actual">Estado Actual</label>
                    <input type="text" class="form-control" id="status_actual" value="{{strtoupper( $tramite->estado) }}" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="status">Modificar tramite</label>
                    <select name="status" id="status" class="form-control">
                        <option value="pendiente" {{ $tramite->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="en_proceso" {{ $tramite->estado == 'en_proceso' ? 'selected' : '' }}>En proceso</option>
                        <option value="completado" {{ $tramite->estado == 'completado' ? 'selected' : '' }}>Completado</option>
                        <option value="rechazado" {{ $tramite->estado == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                    </select>
                </div>
            </div>
        </div>

    
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="id_movimiento">ID del Movimiento</label>
                    <input type="text" class="form-control" id="id_movimiento" value="{{ $movimiento->id }}" disabled>
                </div>
            </div>
        </div>

        <h3 class="mt-3 mb-4">Productos Asociados</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->producto->nombre }}</td>
                        <td>{{ $producto->producto->descripcion }}</td>
                        <td>{{ $producto->cantidad }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Botón para guardar cambios -->
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>

