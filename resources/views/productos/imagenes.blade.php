@extends('layout.app')

@section('content')
<main class="app-main">
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 my-5">
                        <div class="px-2 row">
                            <div class="col-lg-12">
                                @include('flash::message')
                            </div>
                            <div class="col-md-6 col-6">
                                <h3 class="p-2 bold">Imágenes de {{ $producto->nombre }}</h3>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <a href="{{ route('almacen') }}" class="btn btn-primary round mx-1">Volver</a>
                            </div>
                        </div>
                        <div class="card-body">
                            {!! Form::model($producto, ['route' => ['agregarImagen', $producto->id], 'method' => 'POST', 'class' => 'btn-create', 'enctype' => 'multipart/form-data']) !!}

                            <!-- Mostrar imágenes actuales -->
                            <div class="mb-4">
                                <h5>Imágenes Actuales:</h5>
                                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                                    @foreach($imagenes as $imagen)
                                        <div class="col">
                                            <div class="card">
                                                <img src="{{ asset($imagen->url) }}" class="card-img-top img-thumbnail"
                                                    alt="Imagen del producto">
                                                <div class="card-body d-flex justify-content-end">
                                                    <button type="button" class="btn btn-danger btn-sm btn-remove-image"
                                                        data-url="{{ route('removerImagen', ['id' => $imagen->id]) }}">
                                                        <span class="material-icons">delete</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Campo para seleccionar nuevas imágenes -->
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        {!! Form::label('imagenes', 'Seleccionar Nuevas Imágenes:', ['class' => 'bold']) !!}
                                        {!! Form::file('imagenes[]', ['class' => 'form-control round', 'accept' => 'image/*', 'multiple' => true, 'id' => 'imagenes2']) !!}
                                        <small class="text-muted">Puedes subir hasta 5 nuevas imágenes.</small>
                                    </div>
                                </div>
                                <div class="col-12">
                                <div class="form-group col-sm-12 col-md-6" id="imagenes-preview2"></div>
                                </div>
                            </div>

                            <!-- Botones de acción -->
                            <div class="float-end">
                                {!! Form::submit('Guardar', ['class' => 'btn btn-primary round']) !!}
                                <a href="{{ route('almacen') }}" class="btn btn-danger round">Cancelar</a>
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
@include('layout.script')
<script src="{{ asset('js/adminlte.js') }}"></script>
<script src="{{asset('js/sweetalert2.js')}}"></script>
<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function () {
    let imagenesInput = document.getElementById('imagenes2');
    let previewContainer = document.getElementById('imagenes-preview2');
    let imagenesError = document.getElementById('imagenes_error2');

    // Función para manejar la previsualización y eliminación de imágenes
    imagenesInput.addEventListener('change', function (event) {
        let files = event.target.files;
        let maxFiles = 5; // Máximo de archivos permitidos

        // Limpiar la previsualización actual
        previewContainer.innerHTML = '';


          // Mostrar previsualización de cada imagen seleccionada
    Array.from(files).forEach((file) => {
        let reader = new FileReader();
        reader.onload = function (e) {
            let imgContainer = document.createElement('div');
            imgContainer.style.position = 'relative';
            imgContainer.style.display = 'inline-block';
            imgContainer.style.margin = '5px';

            let img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = '100px';
            img.style.height = '100px';
            img.style.objectFit = 'cover';

            let removeBtn = document.createElement('button');
            removeBtn.innerText = 'X';
            removeBtn.style.position = 'absolute';
            removeBtn.style.top = '0';
            removeBtn.style.right = '0';
            removeBtn.style.backgroundColor = 'red';
            removeBtn.style.color = 'white';
            removeBtn.style.border = 'none';
            removeBtn.style.borderRadius = '50%';
            removeBtn.style.width = '20px';
            removeBtn.style.height = '20px';
            removeBtn.style.cursor = 'pointer';

            removeBtn.addEventListener('click', function () {
                imgContainer.remove();
                let dt = new DataTransfer();
                for (let i = 0; i < files.length; i++) {
                    if (files[i] !== file) {
                        dt.items.add(files[i]);
                    }
                }
                imagenesInput.files = dt.files;
            });

            imgContainer.appendChild(img);
            imgContainer.appendChild(removeBtn);
            previewContainer.appendChild(imgContainer);
        }
        reader.readAsDataURL(file);
    });
    });

    // Manejar eliminación de imágenes actuales
    $('.btn-remove-image').click(function (event) {
        event.preventDefault();
        var url = $(this).data('url');

        // Mostrar SweetAlert para confirmar la eliminación
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará la imagen permanentemente.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Realizar la petición AJAX para eliminar la imagen
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        Swal.fire(
                            '¡Eliminado!',
                            'La imagen ha sido eliminada exitosamente.',
                            'success'
                        );
                        location.reload(); // Recargar la página después de eliminar la imagen
                    },
                    error: function (error) {
                        console.error('Error al eliminar la imagen:', error);
                        Swal.fire(
                            'Error',
                            'Hubo un error al intentar eliminar la imagen.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});

</script>
@endsection