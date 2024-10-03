@extends('layout.app')
@section('content')

<main class="app-main"> <!--begin::App Content Header-->
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Bienvenido, {{Auth::user()->name}}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Dashboard
                        </li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content Header--> <!--begin::App Content-->
    <div class="app-content"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row"> <!--begin::Col-->
                <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                    <div class="small-box bg-primary-app">
                        <div class="inner">
                            <h3>{{$productos}}</h3>
                            <p>Productos</p>
                        </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path
                                d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z">
                            </path>
                        </svg> <a href={{route('inventario')}}
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            Detalles <i class="bi bi-link-45deg"></i> </a>
                    </div> <!--end::Small Box Widget 1-->
                </div> <!--end::Col-->
                <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 2-->
                    <div class="small-box bg-success-app">
                        <div class="inner">
                            <h3>{{$tramites}}<sup class="fs-5"></sup></h3>
                            <p>Tramites</p>
                        </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path
                                d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z">
                            </path>
                        </svg> <a href="{{route('tramites.index')}}"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            Detalles <i class="bi bi-link-45deg"></i> </a>
                    </div> <!--end::Small Box Widget 2-->
                </div> <!--end::Col-->
                <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 3-->
                    <div class="small-box bg-danger-app">
                        <div class="inner">
                            <h3>{{$solicitudes}}</h3>
                            <p>Solicitudes</p>
                        </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path
                                d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                            </path>
                        </svg> <a href="{{route('solicitudes.index')}}"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            Detalles <i class="bi bi-link-45deg"></i> </a>
                    </div> <!--end::Small Box Widget 3-->
                </div> <!--end::Col-->
                <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 4-->
                    <div class="small-box bg-warning-app">
                        <div class="inner">
                            <h3>{{$asignaciones}}</h3>
                            <p>Asignaciones</p>
                        </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z">
                            </path>
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z">
                            </path>
                        </svg> <a href="{{route('asignaciones.index')}}"
                            class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                            Detalles <i class="bi bi-link-45deg"></i> </a>
                    </div> <!--end::Small Box Widget 4-->
                </div> <!--end::Col-->

                <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 4-->
                    <div class="small-box bg-sky-app">
                        <div class="inner">
                            <h3>{{$requerimientos}}</h3>
                            <p>Requerimientos</p>
                        </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z">
                            </path>
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z">
                            </path>
                        </svg> <a href="{{route('requerimientos.index')}}"
                            class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                            Detalles <i class="bi bi-link-45deg"></i> </a>
                    </div> <!--end::Small Box Widget 4-->
                </div> <!--end::Col-->
                <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 4-->
                    <div class="small-box text-bg-dark">
                        <div class="inner">
                            <h3>{{$bajoStock}}</h3>
                            <p>Bajo Stock</p>
                        </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z">
                            </path>
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z">
                            </path>
                        </svg> <a href="{{route('inventario')}}"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            Detalles <i class="bi bi-link-45deg"></i> </a>
                    </div> <!--end::Small Box Widget 4-->
                </div> <!--end::Col-->
                <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 4-->
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3>{{$proveedores}}</h3>
                            <p>Proveedores</p>
                        </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z">
                            </path>
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z">
                            </path>
                        </svg> <a href="{{route('proveedores.index')}}"
                            class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                            Detalles <i class="bi bi-link-45deg"></i> </a>
                    </div> <!--end::Small Box Widget 4-->
                </div> <!--end::Col-->
                <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 4-->
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3>{{$personal}}}</h3>
                            <p>Personal</p>
                        </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z">
                            </path>
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z">
                            </path>
                        </svg> <a href="{{route('personal.index')}}"
                            class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                            Detalles <i class="bi bi-link-45deg"></i> </a>
                    </div> <!--end::Small Box Widget 4-->
                </div> <!--end::Col-->
            </div> <!--end::Row--> <!--begin::Row-->
            <div class="row">
                <div class="col-lg-5 card p-2">
                    <canvas id="productosChart" width="300" height="300"></canvas>

                </div>
                <div class="col-lg-6 card ">
                    <canvas id="tramitesChart" width="300" height="300"></canvas>
                </div>
            </div>
        </div> <!--end::Container-->
    </div> <!--end::App Content-->
</main> <!--end::App Main--> <!--begin::Footer-->


@include('layout.script')
<script src="{{ asset('js/adminlte.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Obtener los datos de productos desde la variable de PHP
    const productosData = @json($dataProductos);

    const ctx = document.getElementById('productosChart').getContext('2d');
    const productosChart = new Chart(ctx, {
        type: 'pie', // Tipo de gráfico
        data: {
            labels: Object.keys(productosData), // Nombres de los productos
            datasets: [{
                label: 'Cantidad de Productos',
                data: Object.values(productosData), // Cantidades de cada producto
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Distribución de Productos en el Inventario'
                }
            }
        }
    });
</script>
<script>
    const ctx2 = document.getElementById('tramitesChart').getContext('2d');

    // Nombres de los meses en español
    const labels = [
        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 
        'Junio', 'Julio', 'Agosto', 'Septiembre', 
        'Octubre', 'Noviembre', 'Diciembre'
    ];

    // Inicializamos la estructura de datos para la gráfica
    const datasets = [];
    @foreach ($tramitesPorMes as $tipo => $meses)
        datasets.push({
            label: '{{ $tipo }}',
            data: [
                @for ($i = 1; $i <= 12; $i++)
                    {{ $meses[$i] ?? 0 }},
                @endfor
            ],
            borderColor: randomColor(), // Cambia a un color aleatorio o específico
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            fill: true // Esto puede ser true o false según tu preferencia
        });
    @endforeach

    const data = {
        labels: labels,
        datasets: datasets
    };
    console.log(data);

    const config = {
        type: 'line', // o 'bar' para un gráfico de barras
        data: data,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Cantidad'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Mes'
                    }
                }
            }
        }
    };

    const tramitesChart = new Chart(ctx2, config);

    function randomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
</script>
@endsection