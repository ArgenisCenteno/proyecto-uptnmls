<html>

@include('layout.head')

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper"> <!--begin::Header-->
    @include('layout.cabecera')
   
    @yield('content')
    @stack('third_party_scripts')
    @stack('page_scripts')
</div>  
@yield('js')
@include('layout.script')
@include('sweetalert::alert')
@include('layout.datatables_css')
@include('layout.datatables_js')

</body>

</html>