<div class="row">
    <!-- Nombre Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('nombre', 'Nombre:', ['class' => 'bold']) !!}
        {!! Form::text('nombre', $caja->nombre, ['class' => 'form-control', 'readonly']) !!}
    </div>
    
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('monto_inicial_bolivares', 'Monto Inicial Bolivares:', ['class' => 'bold']) !!}
        {!! Form::text('monto_inicial_bolivares', null, ['class' => 'form-control money-format']) !!}
    </div>
</div>

<div class="row">
    <!-- Monto Inicial Bolivares Field -->
 
    
    <!-- Monto Inicial Dolares Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('monto_inicial_dolares', 'Monto Inicial Dolares:', ['class' => 'bold']) !!}
        {!! Form::text('monto_inicial_dolares', null, ['class' => 'form-control money-format']) !!}
    </div>
</div>

<!-- Submit Field -->
<div class="float-end">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary round']) !!}
    <a href="{{ route('categorias.index') }}" class="btn btn-danger">Cancelar</a>
</div>
