@extends('layouts.admin')

@section('content')
    @if (session('success'))
        <div class="toast-container position-fixed top-0 end-0 p-3" id="userSuccess">
            <div class="toast show bg-success" data-bs-theme="dark" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <img src="{{ asset('images/igm.png') }}" class="rounded me-2" width="50" alt="...">
                    <strong class="me-auto">DIAHSISKA</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                </div>
            </div>
        </div>
    @endif
    <a href="course/upload" class="btn btn-primary mb-3 px-3 fw-bold"><i class="fa-solid fa-user-plus mr-2"></i>Upload
        Data</a>
    <div class="p-3 bg-white shadow-lg rounded-3 mb-3">
        {!! $dataTable->table(['class' => 'table table-hover']) !!}
    </div>
@endsection

@push('scripts')
    <script>
        const toast = document.getElementById('userSuccess');
        if (toast) {
            window.onload = function() {
                setTimeout(function() {
                    toast.style.display = 'none';
                }, 5000);
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/colreorder/2.0.0/js/dataTables.colReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.1/js/responsive.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/searchpanes/2.3.0/js/dataTables.searchPanes.min.js"></script>
    <script src="https://cdn.datatables.net/searchpanes/2.3.0/js/searchPanes.bootstrap5.min.js"></script>
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
