@extends('layouts.main')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="container mb-5">
        @include('partials.buttonBack')

        <div class="row">
            <div class="col-md-6">
                <h3 class="mt-3 text-center">Data KRS {{ $title ?? '' }}</h3>
                <canvas id="chartFakultas"></canvas>

            </div>
            <div class="col-md-6">
                <h3 class="mt-3 text-center">Data KRS Program Studi</h3>
                <canvas id="chartProdi"></canvas>
            </div>
        </div>

        <hr>
        <h3 class="mt-3">Data Mahasiswa Baru</h3>
        <div class="overflow-auto">
            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th>Program Studi</th>
                        @foreach ($newListTahun as $tahun)
                            <th>{{ $tahun }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listProdi as $prodi)
                        <tr>
                            <td>{{ $prodi }}</td>
                            @foreach ($newListTahun as $index => $tahun)
                                @php
                                    $currentValue = $dataMBProdi[$tahun]->$prodi ?? 0;
                                    $previousValue =
                                        $index > 0 ? $dataMBProdi[$newListTahun[$index - 1]]->$prodi ?? 0 : null;
                                    $percentageChange = $previousValue
                                        ? (($currentValue - $previousValue) / $previousValue) * 100
                                        : null;
                                    $class =
                                        $percentageChange !== null
                                            ? ($percentageChange > 0
                                                ? 'increase'
                                                : 'decrease')
                                            : '';
                                @endphp
                                <td class="{{ $class }}">
                                    {{ $currentValue }}

                                    @if ($percentageChange < 0)
                                        <span class="text-danger">
                                            @if ($percentageChange !== null)
                                                ({{ number_format($percentageChange, 2) }}%)
                                            @endif
                                        </span>
                                    @endif
                                    @if ($percentageChange > 0)
                                        <span class="text-success">
                                            @if ($percentageChange !== null)
                                                ({{ number_format($percentageChange, 2) }}%)
                                            @endif
                                        </span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total</th>
                        @foreach ($newListTahun as $tahun)
                            <th>
                                {{ collect($listProdi)->sum(function ($prodi) use ($dataMBProdi, $tahun) {
                                    return $dataMBProdi[$tahun]->$prodi ?? 0;
                                }) }}
                            </th>
                        @endforeach
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
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
        @foreach ($listProdi as $prodi)
            let {{ str_replace(' ', '_', $prodi) }} = [];
        @endforeach

        let localStorageDataKRS = window.localStorage.getItem('{{ $localStorageKeyKRS }}');
        let dataKRS = JSON.parse(localStorageDataKRS);
        if (dataKRS) {
            for (let tahun in dataKRS) {
                labels.push(tahun);
                jmlAll.push(dataKRS[tahun][0]['JmlAll']);
                @foreach ($listProdi as $prodi)
                    {{ str_replace(' ', '_', $prodi) }}.push(dataKRS[tahun][0]['{{ $prodi }}']);
                @endforeach
            }
            let chartProdiContainer = document.getElementById('chartProdi');
            let chartFakultasContainer = document.getElementById('chartFakultas');
            let chartProdi = new Chart(chartProdiContainer, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        @foreach ($listProdi as $index => $prodi)
                            {
                                label: '{{ $prodi }}',
                                data: {{ str_replace(' ', '_', $prodi) }},
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
            let chartFakultas = new Chart(chartFakultasContainer, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Fakultas',
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
