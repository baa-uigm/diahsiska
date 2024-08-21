@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-9">
                @include('partials.buttonBack')
            </div>
            <div class="col-md-3 pt-3">
                <form class="d-flex gap-2 mb-3">
                    <select id="tahun" class="form-select">
                        <option value=" ">All Years</option>
                        @foreach ($listTahun as $item)
                            <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary" id="filter" type="button"><i
                            class="fa-solid fa-filter fs-5"></i></button>
                </form>
            </div>
        </div>

        <div class="p-3 bg-white shadow-lg rounded-3 mb-3">
            <h1 class="titleTable">KRS Periode 2019-2023</span></h1>
            {!! $dataTable->table(['class' => 'table table-hover']) !!}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const toastContainer = document.getElementById('toastContainer');
        if (toastContainer) {
            const toasts = toastContainer.getElementsByClassName('toast');
            setTimeout(function() {
                for (let i = 0; i < toasts.length; i++) {
                    let toast = toasts[i];
                    toast.classList.add('fade');
                    setTimeout(function() {
                        toastElement.remove();
                    }, 1000);
                }
            }, 5000);
        }

        const prodi = '{{ $title }}';
        const kode = 1;
        $(document).ready(function() {
            const table = $('#study-table');
            table.on('preXhr.dt', function(e, settings, data) {
                data.kode = kode;
                data.prodi = prodi;
                data.tahun = $('#tahun').val();
                console.log(data.kode);
            });

            $('#filter').on('click', function() {
                table.DataTable().ajax.reload();
                return false;
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/autofill/2.7.0/js/dataTables.autoFill.min.js"></script>
    <script src="https://cdn.datatables.net/autofill/2.7.0/js/autoFill.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/colreorder/2.0.0/js/dataTables.colReorder.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.5.2/js/dataTables.dateTime.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/5.0.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/4.0.1/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/keytable/2.12.0/js/dataTables.keyTable.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.1/js/responsive.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.5.0/js/dataTables.rowGroup.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.5.0/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/scroller/2.4.1/js/dataTables.scroller.min.js"></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.7.0/js/dataTables.searchBuilder.min.js"></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.7.0/js/searchBuilder.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/searchpanes/2.3.0/js/dataTables.searchPanes.min.js"></script>
    <script src="https://cdn.datatables.net/searchpanes/2.3.0/js/searchPanes.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/select/2.0.0/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/staterestore/1.4.0/js/dataTables.stateRestore.min.js"></script>
    <script src="https://cdn.datatables.net/staterestore/1.4.0/js/stateRestore.bootstrap5.min.js"></script>
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
