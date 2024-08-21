@extends('layouts.main')

@section('content')
    <div class="container mb-5">
        @include('partials.buttonBack')
        <div class="row">
            <div class="col-md-6">
                <h3 class="mt-3 text-center">Data KRS UIGM</h3>
                <canvas id="chartUIGM"></canvas>
            </div>
            <div class="col-md-6">
                <h3 class="mt-3 text-center">Data KRS Fakultas</h3>
                <canvas id="chartFakultas"></canvas>
            </div>
        </div>
        <hr>
        <h3 class="mt-3">Data Mahasiswa Baru</h3>
        <div class="overflow-auto">
            <table id="data-table" class="table text-center table-hover" style="vertical-align: middle">
                <thead>
                    <tr>
                        <th>Fakultas</th>
                        @foreach ($listTahun as $item)
                            @if ($item % 2)
                                <th>{{ $item }}</th>
                            @endif
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let localStorageData = window.localStorage.getItem('{{ $localStorageKeyMB }}');
        let dataMBFakultas = JSON.parse(localStorageData);

        if (dataMBFakultas) {
            let table = document.getElementById('data-table').getElementsByTagName('tbody')[0];

            Object.keys(dataMBFakultas).forEach(function(fakultas) {
                let rowData = dataMBFakultas[fakultas][0];
                let row = table.insertRow(-1);
                let cellFakultas = row.insertCell(0);
                let cellData2019 = row.insertCell(1);
                let cellData2020 = row.insertCell(2);
                let cellData2021 = row.insertCell(3);
                let cellData2022 = row.insertCell(4);
                let cellData2023 = row.insertCell(5);
                cellFakultas.innerHTML = fakultas;
                cellData2019.innerHTML = rowData.Data2019;
                cellData2020.innerHTML = getCellWithIcon(rowData.Data2019, rowData.Data2020);
                cellData2021.innerHTML = getCellWithIcon(rowData.Data2020, rowData.Data2021);
                cellData2022.innerHTML = getCellWithIcon(rowData.Data2021, rowData.Data2022);
                cellData2023.innerHTML = getCellWithIcon(rowData.Data2022, rowData.Data2023);
            });
        } else {
            console.error('Data tidak ditemukan dalam localStorage');
        }

        function getCellWithIcon(previousValue, currentValue) {
            let percentageChange = calculatePercentageChange(previousValue, currentValue);
            let iconClass = '';
            if (percentageChange > 0) {
                iconClass = 'fa-solid fa-arrow-up mx-1';
                spanClass = 'text-success ms-2';
            } else if (percentageChange < 0) {
                iconClass = 'fa-solid fa-arrow-down mx-1';
                spanClass = 'text-danger ms-2';
            }
            return currentValue + '<div class="' + spanClass + '">(<i class="' + iconClass + '"></i>' +
                percentageChange.toFixed(1) + '%)</div>';
        }

        function calculatePercentageChange(oldValue, newValue) {
            if (oldValue === 0) return 0;
            return ((newValue - oldValue) / oldValue) * 100;
        }
    </script>
    <script>
        let labels = [];
        let jmlAll = [];
        let borderColor = [
            'rgba(255, 0, 0, 1)',
            'rgb(0, 255, 0, 1)',
            'rgba(0, 0, 255, 1)',
            'rgba(255, 255, 0, 1)',
            'rgba(0 ,255, 255, 1)',
        ];
        let backgroundColor = [
            'rgba(255, 0, 0, 0.2)',
            'rgb(0, 255, 0, 0.2)',
            'rgba(0, 0, 255, 0.2)',
            'rgba(255, 255, 0, 0.2)',
            'rgba(0 ,255, 255, 0.2)',
        ];
        @foreach ($listFakultas as $fakultas)
            let {{ str_replace(' ', '_', $fakultas) }} = [];
        @endforeach

        let localStorageDataKRS = window.localStorage.getItem('{{ $localStorageKeyKRS }}');
        let dataKRS = JSON.parse(localStorageDataKRS);
        if (dataKRS) {
            for (let tahun in dataKRS) {
                labels.push(tahun);
                jmlAll.push(dataKRS[tahun][0]['JmlAll']);
                @foreach ($listFakultas as $fakultas)
                    {{ str_replace(' ', '_', $fakultas) }}.push(dataKRS[tahun][0][
                        '{{ str_replace(' ', '_', $fakultas) }}'
                    ]);
                @endforeach
            }
            let chartUIGMContainer = document.getElementById('chartUIGM');
            let chartFakultasContainer = document.getElementById('chartFakultas');
            let chartFakultas = new Chart(chartFakultasContainer, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        @foreach ($listFakultas as $index => $fakultas)
                            {
                                label: '{{ $fakultas }}',
                                data: {{ str_replace(' ', '_', $fakultas) }},
                                backgroundColor: backgroundColor[{{ $index }}],
                                borderColor: borderColor[{{ $index }}],
                                borderWidth: 1
                            },
                        @endforeach
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            let chartUIGM = new Chart(chartUIGMContainer, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'UIGM',
                        data: jmlAll,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>
@endpush
