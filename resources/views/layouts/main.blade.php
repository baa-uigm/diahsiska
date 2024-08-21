<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DIAHSISKA - {{ $title ?? '' }}</title>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/autofill/2.7.0/css/autoFill.bootstrap5.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/colreorder/2.0.0/css/colReorder.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/datetime/1.5.2/css/dataTables.dateTime.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/fixedcolumns/5.0.0/css/fixedColumns.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/fixedheader/4.0.1/css/fixedHeader.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/keytable/2.12.0/css/keyTable.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/3.0.1/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowgroup/1.5.0/css/rowGroup.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.5.0/css/rowReorder.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/scroller/2.4.1/css/scroller.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/searchbuilder/1.7.0/css/searchBuilder.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/searchpanes/2.3.0/css/searchPanes.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/select/2.0.0/css/select.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/staterestore/1.4.0/css/stateRestore.bootstrap5.min.css" rel="stylesheet">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="h-100">

    @include('partials.navigate')

    <main class="container-fluid">
        @yield('content')
    </main>

    @if (Auth::user()->role == 'admin')
        @yield('admin')
    @endif

    @include('partials.footer')


    {{-- Bootstrap --}}
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @stack('scripts')
</body>

</html>
