<div class="form-group col-sm-12 col-md-6">
    {!! Form::label('tipo', 'Tipo de Requerimiento:', ['class' => 'bold']) !!}
    {!! Form::select('tipo', ['asignacion' => 'Asignación', 'solicitud' => 'Solicitud'], null, ['class' => 'form-control round', 'required']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('uso', 'Uso:', ['class' => 'bold']) !!}
    {!! Form::textarea('uso', null, ['class' => 'form-control round', 'rows' => 3, 'required']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('descripcion', 'Descripción:', ['class' => 'bold']) !!}
    {!! Form::textarea('descripcion', null, ['class' => 'form-control round', 'rows' => 3, 'required']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::submit('Registrar ', ['class' => 'btn btn-primary']) !!}
</div>
