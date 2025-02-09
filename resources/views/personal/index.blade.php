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
                            <h3 class="p-2 bold">Personal</h3>
                        </div>
                        <div class="col-md-6 col-6">
                        <div class="d-flex justify-content-end mt-3">
                                <a href="{{route('personal.create')}}" class="btn btn-primary  round mx-1" >Registrar</a>
                       <!-- Blade View -->
<a href="{{ route('export.personal') }}" class="btn btn-success">Exportar Personal</a>

                            </div>
                        </div>
                       
                    </div>
                    <div class="card-body">
                  
                        @include('personal.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main> <!--end::App Main--> <!--begin::Footer-->
@endsection
