@extends('layout.app')
@section('content')
<main class="app-main"> <!--begin::App Content Header-->
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
                                <h3 class="p-2 bold">Solicitudes</h3>
                            </div>
                            <div class="col-md-6">
                                <form action="{{ route('solicitudes.export') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="from_date">Desde:</label>
                                        <input type="date" name="from_date" id="from_date" class="form-control"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="to_date">Hasta:</label>
                                        <input type="date" name="to_date" id="to_date" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Exportar</button>
                                </form>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <a href="{{route('solicitudes.create')}}"
                                    class="btn btn-primary  round mx-1">Registrar</a>
                            </div>
                        </div>
                        <div class="card-body">

                            @include('solicitudes.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main> <!--end::App Main--> <!--begin::Footer-->
@endsection