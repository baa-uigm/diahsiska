@extends('layouts.main')

@section('content')
    <div class="container">
        @include('partials.buttonBack')
        <div class="py-4">
            <ul class="nav nav-tabs border-black" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="simple-tab-0" data-bs-toggle="tab" href="#simple-tabpanel-0" role="tab"
                        aria-controls="simple-tabpanel-0" aria-selected="true"><i
                            class="fa-solid fa-chart-column me-2"></i>Grafik</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="simple-tab-1" data-bs-toggle="tab" href="#simple-tabpanel-1"
                        role="tab" aria-controls="simple-tabpanel-1" aria-selected="false"><i
                            class="fa-solid fa-table me-2"></i>Table</a>
                </li>
            </ul>
            <div class="tab-content shadow-lg p-3 border-top-0 rounded-bottom" style="border: 1px solid black"
                id="tab-content">
                <div class="tab-pane" id="simple-tabpanel-0" role="tabpanel" aria-labelledby="simple-tab-0">
                    <div class="row justify-content-center align-items-center p-3">
                        <h4 class="text-center mb-4">Data Fakultas Dengan Pujian</h4>
                        <div class="col-md-6">
                            <canvas id="chartTahun"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="chartProdi"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="chartSeluruh"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="chartFourYears"></canvas>
                        </div>
                    </div>
                </div>
                <div class="tab-pane active" id="simple-tabpanel-1" role="tabpanel" aria-labelledby="simple-tab-1">
                    <div class="row justify-content-end align-items-center">
                        <div class="col-md-7">
                            <h3 class="h3">Daftar Mahasiswa Dengan Pujian</h3>
                        </div>
                        <div class="col-md-5">
                            <form class="d-flex gap-2">
                                <select class="form-select border-black" id="prodi">
                                    <option value=" ">All Records</option>
                                    @foreach ($listProdi as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                                <select id="tahun" class="form-select w-50 border-black">
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
                    {!! $dataTable->table(['class' => 'table table-hover']) !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const fakultas = '{{ $title }}';
        $(document).ready(function() {
            const table = $('#graduation-table');
            table.on('preXhr.dt', function(e, settings, data) {
                data.fakultas = fakultas;
                data.prodi = $('#prodi').val();
                data.tahun = $('#tahun').val();
            });

            $('#filter').on('click', function() {
                table.DataTable().ajax.reload();
                return false;
            });
        });

        const dataTahun = @json($dataTahun);

        let labelsTahun = dataTahun.map(item => item.tahun);
        let dpDataTahun = dataTahun.map(item => item.DP);

        let ccT = document.getElementById('chartTahun');
        let ChartTahun = new Chart(ccT, {
            type: 'line',
            data: {
                labels: labelsTahun,
                datasets: [{
                    label: ['Tahun'],
                    data: dpDataTahun,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Data Tahun Dengan Pujian (Cum Laude)',
                        align: 'start',
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });
    </script>

    <script>
        const dataProdi = @json($dataProdi);

        let ccF = document.getElementById('chartProdi');
        let ChartProdi = new Chart(ccF, {
            type: 'bar',
            data: {
                labels: ['Prodi'],
                datasets: []
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Data Prodi Dengan Pujian (Cum Laude)',
                        align: 'start',
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });

        const backgroundColors = [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(87, 206, 86, 0.2)',
            'rgba(230, 60, 230, 0.2)',
        ];

        const borderColors = [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(255, 206, 86)',
            'rgb(87, 206, 86)',
            'rgb(230, 60, 230)',
        ];

        dataProdi.forEach((item, index) => {
            let dataset = {
                label: item.prodi,
                data: [item.DP],
                backgroundColor: backgroundColors[index % backgroundColors.length],
                borderColor: borderColors[index % backgroundColors.length],
                borderWidth: 1
            };

            ChartProdi.data.datasets.push(dataset);
        });

        ChartProdi.update();
    </script>

    <script>
        const dataSeluruh = @json($dataSeluruh);
        let labelsSeluruh = dataSeluruh.map(item => item.tahun);
        let dpDataSeluruh = dataSeluruh.map(item => item.DP);
        let smDataSeluruh = dataSeluruh.map(item => item.SM);
        let mDataSeluruh = dataSeluruh.map(item => item.M);

        let ccS = document.getElementById('chartSeluruh');
        let ChartSeluruh = new Chart(ccS, {
            type: 'line',
            data: {
                labels: labelsSeluruh,
                datasets: [{
                        label: 'Cum Laude',
                        data: dpDataSeluruh,
                        fill: false,
                        borderColor: 'rgb(255, 99, 132)',
                        tension: 0.1
                    },
                    {
                        label: 'Sangat Memuaskan',
                        data: smDataSeluruh,
                        fill: false,
                        borderColor: 'rgb(54, 162, 235)',
                        tension: 0.1
                    },
                    {
                        label: 'Memuaskan',
                        data: mDataSeluruh,
                        fill: false,
                        borderColor: 'rgb(255, 206, 86)',
                        tension: 0.1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Data Lulusan Mahasiswa (Kategori)',
                        align: 'center',
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });
    </script>

    <script>
        const dataFourYears = @json($dataFourYears);
        let labelsFourYears = dataFourYears.map(item => item.tahun);
        let lessFourYears = dataFourYears.map(item => item.lessFourYears);
        let moreFourYears = dataFourYears.map(item => item.moreFourYears);

        let cCFY = document.getElementById('chartFourYears');
        let ChartFourYears = new Chart(cCFY, {
            type: 'line',
            data: {
                labels: labelsFourYears,
                datasets: [{
                        label: 'Masa Studi < 4',
                        data: lessFourYears,
                        fill: false,
                        borderColor: 'rgb(255, 99, 132)',
                        tension: 0.1
                    },
                    {
                        label: 'Masa Studi > 4',
                        data: moreFourYears,
                        fill: false,
                        borderColor: 'rgb(54, 162, 235)',
                        tension: 0.1
                    },
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Data Lulusan Mahasiswa (Kategori)',
                        align: 'center',
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });
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
