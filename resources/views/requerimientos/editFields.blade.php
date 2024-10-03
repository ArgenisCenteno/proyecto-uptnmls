<div class="form-group col-sm-12 col-md-6">
    {!! Form::label('tipo', 'Tipo de Requerimiento:', ['class' => 'bold']) !!}
    {!! Form::select('tipo', ['asignacion' => 'Asignación', 'solicitud' => 'Solicitud'], $requerimiento->tipo, ['class' => 'form-control round', 'required']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('uso', 'Uso:', ['class' => 'bold']) !!}
    {!! Form::textarea('uso', $requerimiento->uso, ['class' => 'form-control round', 'rows' => 3, 'required']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('descripcion', 'Descripción:', ['class' => 'bold']) !!}
    {!! Form::textarea('descripcion', $requerimiento->descripcion, ['class' => 'form-control round', 'rows' => 3, 'required']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
</div>
