@extends('layouts.main')

@section('content')
    @include('partials.buttonBack')
    <div class="row align-items-center my-5">
        <div class="col-md-5 mb-3">
            <canvas id="chartStatusMahasiswa" style="margin: 0 auto;"></canvas>
        </div>
        <div class="col-md-6" style="position: relative; height:50vh;">
            <canvas id="chartProgramStudi" class="mt-5"></canvas>
        </div>
    </div>
    <div class="row justify-content-center align-items-center mb-5">
        <div class="col-md-11">
            <div class="row justify-content-between">
                <div class="col-md-6">
                    <h3>Data Tabel</h3>
                </div>
                <div class="col-md-3">
                    <select id="prodiFilter" class="form-select mb-3 border-black">
                        <option value="">Semua Data</option>
                        @foreach ($listProdi as $prodi)
                            <option value="{{ $prodi }}">{{ $prodi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class='table-responsive-sm'>
                <table id="ipkTable" class="table text-center table-bordered border-black">
                    @include('partials.ipk_table')
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var dataProdi = {!! json_encode($dataProdi) !!};
        var statusMahasiswaLabels = @json($listStatusMahasiswa);
        var chartData = [];
        var filteredDataProdi = {};
        var dataStatus = @json($dataStatus);

        for (var key in dataProdi) {
            if (dataProdi[key] > 0) {
                filteredDataProdi[key] = dataProdi[key];
            }
        }

        var labels = Object.keys(filteredDataProdi);
        var data = Object.values(filteredDataProdi);

        for (var i = 0; i < statusMahasiswaLabels.length; i++) {
            var status = statusMahasiswaLabels[i];
            var count = dataStatus[status].length;
            chartData.push(count);
        }

        var backgroundColors = [
            'rgba(255, 99, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(255, 159, 64, 0.5)',
            'rgba(245, 74, 85, 0.5)',
            'rgba(149, 244, 55, 0.5)',
            'rgba(49, 205, 230, 0.5)',
            'rgba(99, 92, 255, 0.5)',
            'rgba(84, 230, 99, 0.5)'
        ];

        var borderColors = [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(255, 206, 86)',
            'rgb(75, 192, 192)',
            'rgb(153, 102, 255)',
            'rgb(255, 159, 64)',
            'rgb(245, 74, 85)',
            'rgb(149, 244, 55)',
            'rgb(49, 205, 230)',
            'rgb(99, 92, 255)',
            'rgb(84, 230, 99)'
        ];

        var statusMahasiswa = document.getElementById('chartStatusMahasiswa');
        var chart = new Chart(statusMahasiswa, {
            type: 'pie',
            data: {
                labels: statusMahasiswaLabels,
                datasets: [{
                    label: 'Status Mahasiswa',
                    backgroundColor: ['#FF6384', '#36A2EB'],
                    data: chartData
                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true
            }
        });

        var programStudi = document.getElementById('chartProgramStudi');
        var myChart = new Chart(programStudi, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Data',
                    data: data,
                    backgroundColor: backgroundColors.slice(0, labels.length), // Warna latar belakang
                    borderColor: borderColors.slice(0, labels.length), // Warna garis tepi
                    borderWidth: 1
                }]
            },
            options: {
                aspectRatio: 2,
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#ipkTable').html(`{!! view('partials.ipk_table', compact('dataStatus'))->render() !!}`);

            $('#prodiFilter').change(function() {
                var selectedProdi = $(this).val();
                if (selectedProdi !== "") {
                    $.ajax({
                        url: '{{ route('filter.ipk') }}',
                        method: 'GET',
                        data: {
                            prodi: selectedProdi
                        },
                        success: function(response) {
                            $('#ipkTable').html(response);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    $('#ipkTable').html(`{!! view('partials.ipk_table', compact('dataStatus'))->render() !!}`);
                }
            });
        });
    </script>
@endpush
