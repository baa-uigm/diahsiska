@extends('layouts.main')

@section('content')
    <div class="container">
        @include('partials.buttonBack')
        <div class="row row-gap-3 align-items-center justify-content-center text-center p-3">
            <h3>Data Nilai {{ $title ?? '' }}</h3>
            @foreach ($listProdi as $prodi)
                <div class="col-md-6">
                    <h4 class="text-center mt-2">{{ $prodi }}</h4>
                    <canvas id="chart-{{ str_replace(' ', '-', strtolower($prodi)) }}"></canvas>
                </div>
            @endforeach
        </div>

        <div class="row justify-content-center text-center my-3">
            <h4>Data Nilai Tabel</h4>
            <div class="col-md-8">
                <select id="selectProdi" class="form-select form-select-sm fw-bold border border-dark">
                    <option value="">Pilih Program Studi</option>
                    @foreach ($listProdi as $prodi)
                        <option value="{{ $prodi }}">{{ $prodi }}</option>
                    @endforeach
                </select>
                <div id="prodiTableContainer" class="mt-2"></div>
            </div>
        </div>
    </div>

    <input type="hidden" id="dataTitle" name="dataTitle" value="{{ $title }}" />
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const data = JSON.parse(window.localStorage.getItem('{{ $localStorageKeyNilai }}'));

        @foreach ($listProdi as $prodi)
            var prodiData = data["{{ $prodi }}"];
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

            prodiData.forEach(function(entry) {
                labels.push(entry.Tahun);
                datasets[0].data.push(entry.A_count);
                datasets[1].data.push(entry.B_count);
                datasets[2].data.push(entry.C_count);
                datasets[3].data.push(entry.D_count);
                datasets[4].data.push(entry.E_count);
            });
            var ctx = document.getElementById('chart-{{ str_replace(' ', '-', strtolower($prodi)) }}');
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let fakultas = document.getElementById('dataTitle').value;
            document.getElementById('selectProdi').addEventListener('change', function() {
                let selectedProdi = this.value;
                let firstOption = this.options[0];
                if (firstOption.value === "") {
                    firstOption.disabled = true;
                }

                fetch('/nilai/' + fakultas + '/get-prodi-table/' + selectedProdi)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('prodiTableContainer').innerHTML = data;
                    });
            });
        });
    </script>
@endpush
