<div class="row">
    <!-- Razón Social Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('razon_social', 'Razón Social:', ['class' => 'bold']) !!}
        {!! Form::text('razon_social', null, ['class' => 'form-control round', 'required']) !!}
    </div>

    <!-- Rif Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('rif', 'RIF:', ['class' => 'bold']) !!}
        {!! Form::text('rif', null, ['class' => 'form-control round', 'required']) !!}
    </div>
    <!-- Teléfono Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('telefono', 'Teléfono:', ['class' => 'bold']) !!}
        {!! Form::text('telefono', null, ['class' => 'form-control round', 'required']) !!}
    </div>

    <!-- Email Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('email', 'Email:', ['class' => 'bold']) !!}
        {!! Form::email('email', null, ['class' => 'form-control round', 'required']) !!}
    </div>


    <!-- Estado Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('estado', 'Estado:', ['class' => 'bold']) !!}
        {!! Form::text('estado', null, ['class' => 'form-control round', 'required']) !!}
    </div>

    <!-- Municipio Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('municipio', 'Municipio:', ['class' => 'bold']) !!}
        {!! Form::text('municipio', null, ['class' => 'form-control round', 'required']) !!}
    </div>

    <!-- Parroquia Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('parroquia', 'Parroquia:', ['class' => 'bold']) !!}
        {!! Form::text('parroquia', null, ['class' => 'form-control round', 'required']) !!}
    </div>

</div>

<!-- Botones de acción -->
<div class="float-end">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary round', 'id' => 'submit_btn']) !!}
    <a href="{{ route('entes.index') }}" class="btn btn-danger round">Cancelar</a>
</div>

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
                rifInput.style.border = '2px solid red'
                submitButton.disabled = true;
            } else {
                rifError.textContent = '';
                rifInput.style.border = ''
                submitButton.disabled = false;
            }
        });
    });
</script>

