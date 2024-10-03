<div class="row">
    <!-- Nombre Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('name', 'Nombre:', ['class' => 'bold']) !!}
        {!! Form::text('name', $tasa->name, ['class' => 'form-control round', 'required']) !!}
    </div>

    <!-- Valor Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('valor', 'Valor:', ['class' => 'bold']) !!}
        {!! Form::number('valor', $tasa->valor, ['class' => 'form-control round', 'step' => '0.01', 'id' => 'valor', 'required']) !!}
        <p id="valor_error" style="color: red; display: none;">El valor no puede quedar vacío o ser negativo.</p>
    </div>

    <!-- Botones de acción -->
    <div class="float-end">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary round', 'id' => 'submit_btn', 'disabled' => true]) !!}
        <a href="{{ route('tasas.index') }}" class="btn btn-danger round">Cancelar</a>
    </div>

    <script src="{{ asset('js/sweetalert2.js') }}"></script>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            let valor = document.getElementById('valor');
            let valorError = document.getElementById('valor_error');
            let submitBtn = document.getElementById('submit_btn');

            // Función para validar el campo de valor
            function validarValor() {
                let valorInput = parseFloat(valor.value);
                let valid = true;

                // Validación del valor
                if (isNaN(valorInput) || valorInput < 0) {
                    valorError.style.display = 'block';
                    valid = false;
                } else {
                    valorError.style.display = 'none';
                }

                // Habilitar o deshabilitar el botón de enviar
                submitBtn.disabled = !valid;
            }

            // Evento para validar el valor en tiempo real
            valor.addEventListener('input', validarValor);
        });
    </script>
</div>
