@extends('layouts.main')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="container">
        @include('partials.buttonBack')
        <div class="row row-gap-3 align-items-center justify-content-center text-center p-3">
            <h2>Data Nilai</h2>
            @foreach ($listFakultas as $fakultas)
                <div class="col-md-6">
                    <h4 class="text-center mt-2">{{ $fakultas }}</h4>
                    <canvas id="chart-{{ str_replace(' ', '-', strtolower($fakultas)) }}"></canvas>
                </div>
            @endforeach
        </div>

        <div class="row justify-content-center text-center my-3">
            <h4>Data Nilai Tabel</h4>
            <div class="col-md-8">
                <select id="selectFakultas" class="form-select form-select-sm fw-bold border border-dark">
                    <option value="" disabled selected>Pilih Fakultas</option>
                    @foreach ($listFakultas as $fakultas)
                        <option value="{{ $fakultas }}">{{ $fakultas }}</option>
                    @endforeach
                </select>
                <div id="fakultasTableContainer" class="mt-2"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('selectFakultas').addEventListener('change', function() {
                var selectedFakultas = this.value;

                fetch('/warek/get-fakultas-table/' + selectedFakultas)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('fakultasTableContainer').innerHTML = data;
                    });
            });
        });
    </script>

    <script>
        const data = JSON.parse(window.localStorage.getItem('{{ $localStorageKeyNilai }}'));
        @foreach ($listFakultas as $fakultas)
            var fakultasData = data["{{ $fakultas }}"];
            var labels = [];
            var datasets = [{
                label: 'A',
                data: [],
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderWidth: 1,
                fill: false
            }, {
                label: 'B',
                data: [],
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderWidth: 1,
                fill: false
            }, {
                label: 'C',
                data: [],
                borderColor: 'rgba(255, 206, 86, 1)',
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderWidth: 1,
                fill: false
            }, {
                label: 'D',
                data: [],
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 1,
                fill: false
            }, {
                label: 'E',
                data: [],
                borderColor: 'rgba(153, 102, 255, 1)',
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderWidth: 1,
                fill: false
            }];

            fakultasData.forEach(function(entry) {
                labels.push(entry.Tahun);
                datasets[0].data.push(entry.A_count);
                datasets[1].data.push(entry.B_count);
                datasets[2].data.push(entry.C_count);
                datasets[3].data.push(entry.D_count);
                datasets[4].data.push(entry.E_count);
            });
            var ctx = document.getElementById('chart-{{ str_replace(' ', '-', strtolower($fakultas)) }}');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        @endforeach
    </script>
@endpush
