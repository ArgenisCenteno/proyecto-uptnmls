<div class="row">
    <!-- Name Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('nombre', 'Nombre:', ['class' => 'bold']) !!}
        {!! Form::text('nombre', null, ['class' => 'form-control round']) !!}
    </div>
    <div class="form-group col-sm-12 col-md-6">
     
    </div>
</div>

<!-- Submit Field -->
<div class="float-end">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary round']) !!}
    <a href="{{ route('categorias.index') }}" class="btn btn-danger">Cancelar</a>
</div>