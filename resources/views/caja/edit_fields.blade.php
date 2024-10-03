<div class="row">
    <!-- Name Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('nombre', 'Nombre:', ['class' => 'bold']) !!}
        {!! Form::text('nombre', $caja->nombre, ['class' => 'form-control round']) !!}
    </div>
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('status', 'Estatus:', ['class' => 'bold']) !!}
        {!! Form::select('status', [
           '1' => 'Activo',
           '0' => 'Inactivo',
            ], $caja->activa, ['class' => 'form-control round']) !!}

    </div>
</div>

<!-- Submit Field -->
<div class="float-end">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary round']) !!}
    <a href="{{ route('cajas.index') }}" class="btn btn-danger">Cancelar</a>
</div>
