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

                                <h3 class="p-2 bold">Tramites</h3>

                               
                            </div>
                            <div class="col-md-6 mt-4">
                            <form action="{{ route('tramites.export') }}" method="POST">
                                    @csrf

                                    <div class="form-group">
                                        <label for="from_date">Fecha desde:</label>
                                        <input type="date" class="form-control" id="from_date" name="from_date"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label for="to_date">Fecha hasta:</label>
                                        <input type="date" class="form-control" id="to_date" name="to_date" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3">Exportar a Excel</button>
                                </form>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                            </div>
                        </div>
                        <div class="card-body">

                            @include('tramites.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main> <!--end::App Main--> <!--begin::Footer-->
@endsection