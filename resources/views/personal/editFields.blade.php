<div class="row">
    <!-- Nombre Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('nombre', 'Nombre:', ['class' => 'bold']) !!}
        {!! Form::text('nombre', $personal->nombre, ['class' => 'form-control round', 'required']) !!}
    </div>

    <!-- Teléfono Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('telefono', 'Teléfono:', ['class' => 'bold']) !!}
        {!! Form::text('telefono', $personal->telefono, ['class' => 'form-control round', 'required', 'id' => 'telefono']) !!}
    </div>

    <!-- RIF Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('rif', 'RIF:', ['class' => 'bold']) !!}
        {!! Form::text('rif', $personal->rif, ['class' => 'form-control round', 'required', 'id' => 'rif']) !!}
    </div>

    <!-- Dirección Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('direccion', 'Dirección:', ['class' => 'bold']) !!}
        {!! Form::textarea('direccion', $personal->direccion, ['class' => 'form-control round', 'rows' => 3, 'required']) !!}
    </div>

    <!-- Área Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('area', 'Área:', ['class' => 'bold']) !!}
        {!! Form::text('area', $personal->area, ['class' => 'form-control round', 'required']) !!}
    </div>

    <!-- Disponible Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('disponible', 'Estado:', ['class' => 'bold']) !!}
        {!! Form::select('disponible', ['1' => 'Activo', '0' => 'Inactivo'], $personal->disponible, ['class' => 'form-control round', 'required']) !!}
    </div>
</div>

<!-- Botones de acción -->
<div class="float-end">
    {!! Form::submit('Actualizar', ['class' => 'btn btn-primary round', 'id' => 'submit_btn']) !!}
    <a href="{{ route('personal.index') }}" class="btn btn-danger round">Cancelar</a>
</div>

<script src="{{ asset('js/sweetalert2.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Restricción para los campos "estado", "parroquia" y "municipio"
        document.querySelectorAll('#estado, #parroquia, #municipio').forEach(function (input) {
            input.addEventListener('input', function () {
                const regex = /^[a-zA-ZñÑ\s]*$/;
                if (!regex.test(this.value)) {
                    this.value = this.value.replace(/[^a-zA-ZñÑ\s]/g, '');
                }
            });
        });

        // Restricción para el campo "telefono"
        const telefonoInput = document.getElementById('telefono');
        telefonoInput.addEventListener('input', function () {
            const regex = /^[0-9]*$/;
            if (!regex.test(this.value) || this.value.length > 11) {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);
            }
        });

        // Validación para el campo "rif"
        const rifInput = document.getElementById('rif');
        const submitButton = document.getElementById('submit_btn');
        const rifError = document.createElement('small');
        rifError.style.color = 'red';
        rifInput.parentNode.appendChild(rifError);

        rifInput.addEventListener('input', function () {
            const rifPattern = /^[VJPG][0-9]{8}[0-9]$/;
            if (!rifPattern.test(this.value)) {
                rifError.textContent = 'RIF inválido. Debe seguir el formato correcto.';
                rifInput.style.border = '2px solid red';
                submitButton.disabled = true;
            } else {
                rifError.textContent = '';
                rifInput.style.border = '';
                submitButton.disabled = false;
            }
        });
    });
</script>
