<div class="row">
    <!-- Nombre Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('nombre', 'Nombre:', ['class' => 'bold']) !!}
        {!! Form::text('nombre', null, ['class' => 'form-control round', 'required']) !!}
    </div>

    <!-- Descripción Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('descripcion', 'Descripción:', ['class' => 'bold']) !!}
        {!! Form::textarea('descripcion', null, ['class' => 'form-control round', 'rows' => 3, 'required']) !!}
    </div>


    <!-- Cantidad Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('cantidad', 'Cantidad:', ['class' => 'bold']) !!}
        {!! Form::number('cantidad', null, ['class' => 'form-control round', 'step' => '1', 'required']) !!}
    </div>

    <!-- Subcategoría Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('sub_categoria_id', 'Subcategoría:', ['class' => 'bold']) !!}
        {!! Form::select('sub_categoria_id', $subcategorias, null, ['class' => 'form-control round', 'placeholder' => 'Selecciona una subcategoría', 'required']) !!}
    </div>

    <!-- Disponible Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('disponible', 'Disponible:', ['class' => 'bold']) !!}
        {!! Form::select('disponible', ['1' => 'Disponible', '0' => 'No Disponible'], null, ['class' => 'form-control round', 'required']) !!}
    </div>

    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('unidad_medida', 'Unidad de Medida:', ['class' => 'bold']) !!}
        {!! Form::select('unidad_medida', [
    'pieza' => 'Pieza',
    'litro' => 'Litro',
    'kilogramo' => 'Kilogramo',
    'metro' => 'Metro',
    'centimetro' => 'Centímetro',
    'unidad' => 'Unidad',
], null, ['class' => 'form-control round', 'placeholder' => 'Selecciona una unidad de medida', 'required']) !!}
    </div>
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('tipo', 'Tipo:', ['class' => 'bold']) !!}
        {!! Form::select('tipo', [
    'CONSUMIBLE' => 'Consumible',
    'RETORNABLE' => 'Retornable',
], null, ['class' => 'form-control round', 'placeholder' => 'Selecciona un tipo', 'required']) !!}
    </div>
</div>

<!-- Botones de acción -->
<div class="float-end">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary round', 'id' => 'submit_btn']) !!}
    <a href="{{ route('inventario') }}" class="btn btn-danger round">Cancelar</a>
</div>

<script src="{{asset('js/sweetalert2.js')}}"></script>