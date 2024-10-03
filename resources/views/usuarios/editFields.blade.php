<div class="row">
    <!-- Name Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('name', 'Nombre:', ['class' => 'bold']) !!}
        {!! Form::text('name', $usuario->name ?? null, ['class' => 'form-control round', 'required']) !!}
        @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Email -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('email', 'Correo Electrónico:', ['class' => 'bold']) !!}
        {!! Form::email('email', $usuario->email ?? null, ['class' => 'form-control round', 'required']) !!}
        @error('email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Teléfono -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('telefono', 'Teléfono:', ['class' => 'bold']) !!}
        {!! Form::text('telefono', $usuario->telefono ?? null, ['class' => 'form-control round', 'required']) !!}
        @error('telefono')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Dirección -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('direccion', 'Dirección:', ['class' => 'bold']) !!}
        {!! Form::text('direccion', $usuario->dirrecion ?? null, ['class' => 'form-control round', 'required']) !!}
        @error('direccion')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Cédula -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('cedula', 'Cédula:', ['class' => 'bold']) !!}
        {!! Form::text('cedula', $usuario->cedula ?? null, ['class' => 'form-control round', 'required']) !!}
        @error('cedula')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Estado -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('status', 'Estado:', ['class' => 'bold']) !!}
        {!! Form::select('status', ['Activo' => 'Activo', 'Inactivo' => 'Inactivo'], $usuario->status ?? null, ['class' => 'form-control round', 'required']) !!}
        @error('status')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Contraseña -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('password', 'Contraseña:', ['class' => 'bold']) !!}
        {!! Form::password('password', ['class' => 'form-control round']) !!} <!-- Aquí puedes dejarlo opcional -->
        <span id="errorMessage" style="color: red; display: none;"></span>
        @error('password')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Role Selection -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('role', 'Rol:', ['class' => 'bold']) !!}
        <select class="form-select" id="role" name="role" required>
            <option value="">Selecciona un rol</option>
            @foreach($roles as $role)
                <option value="{{ $role->name }}" {{ ($usuario->roles->contains('name', $role->name) ? 'selected' : '') }}>{{ ucfirst($role->name) }}</option>
            @endforeach
        </select>
        @error('role')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <!-- Submit Button -->
    <div class="form-group col-sm-12 mt-3">
        {!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
