<div class="row">
    <!-- Name Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('name', 'Nombre:', ['class' => 'bold']) !!}
        {!! Form::text('name', null, ['class' => 'form-control round', 'required']) !!}
        @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Email -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('email', 'Correo Electrónico:', ['class' => 'bold']) !!}
        {!! Form::email('email', null, ['class' => 'form-control round', 'required']) !!}
        @error('email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Teléfono -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('telefono', 'Teléfono:', ['class' => 'bold']) !!}
        {!! Form::text('telefono', null, ['class' => 'form-control round', 'required']) !!}
        @error('telefono')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Dirección -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('direccion', 'Dirección:', ['class' => 'bold']) !!}
        {!! Form::text('direccion', null, ['class' => 'form-control round', 'required']) !!}
        @error('direccion')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Cédula -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('cedula', 'Cédula:', ['class' => 'bold']) !!}
        {!! Form::text('cedula', null, ['class' => 'form-control round', 'required']) !!}
        @error('cedula')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Estado -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('status', 'Estado:', ['class' => 'bold']) !!}
        {!! Form::select('status', ['Activo' => 'Activo', 'Inactivo' => 'Inactivo'], null, ['class' => 'form-control round', 'required']) !!}
        @error('status')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Contraseña -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('password', 'Contraseña:', ['class' => 'bold']) !!}
        {!! Form::password('password', ['class' => 'form-control round', 'required']) !!}
        @error('password')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        <span id="errorMessage" style="color: red; display: none;"></span>
    </div>

    <!-- Role Selection -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('role', 'Rol:', ['class' => 'bold']) !!}
        <select class="form-select" id="role" name="role" required>
            <option value="">Selecciona un rol</option>
            @foreach($roles as $role)
                <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
            @endforeach
        </select>
        @error('role')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Submit Button -->
    <div class="form-group col-sm-12 mt-3">
        {!! Form::submit('Registrar', ['class' => 'btn btn-primary']) !!}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Restricción para los campos "estado", "parroquia" y "municipio"


        // Restricción para el campo "telefono"
        const telefonoInput = document.getElementById('telefono');
        telefonoInput.addEventListener('input', function () {
            const regex = /^[0-9]*$/;
            if (!regex.test(this.value) || this.value.length > 11) {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);
            }
        });

        // Validación para el campo "rif"
        const rifInput = document.getElementById('cedula');
        const submitButton = document.getElementById('submit_btn');
        const rifError = document.createElement('small');
        rifError.style.color = 'red';
        rifInput.parentNode.appendChild(rifError);


        rifInput.addEventListener('input', function () {
            const rifPattern = /^[0-9]{7}[0-9]$/;
            if (!rifPattern.test(this.value)) {
                rifError.textContent = 'Cédula inválido. Debe seguir el formato correcto.';
                rifInput.style.border = '1px solid red'
                submitButton.disabled = true;
            } else {
                rifError.textContent = '';
                rifInput.style.border = ''
                submitButton.disabled = false;
            }
        });

        const passwordInput = document.getElementById('password');
        const errorMessage = document.getElementById('errorMessage');

        // Regular expression to validate password
        const passwordPattern = /^.{8,}$/; // Minimum of 8 characters

        passwordInput.addEventListener('input', function () {
            if (passwordPattern.test(passwordInput.value)) { // Use passwordInput.value
                errorMessage.style.display = 'none';
                // You can submit the form here if needed
                // this.submit();
            } else {
                errorMessage.textContent = 'La contraseña debe tener al menos 8 caracteres.';
                errorMessage.style.display = 'block';
            }
      

    }); })
</script>