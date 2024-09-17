@extends('mobile.frontend.layout.master')

@section('content')

<div class="page-content">
    <div class="page-title page-title-small">
        <h2><a href="{{ route('dashboard') }}" data-back-button><i class="fa fa-arrow-left"></i></a>Beranda</h2>
    </div>
    <div class="card header-card shape-rounded" data-card-height="210">
        <div class="card-overlay bg-highlight opacity-95"></div>
        <div class="card-overlay dark-mode-tint"></div>
        <div class="card-bg preload-img" data-src="admin/mobile/myhr/images/sikad.png"></div>
    </div>

    @foreach ($elektabilitasData as $provinsi => $kabupaten)
        @foreach ($kabupaten as $kabupatenKota => $kecamatan)
            @foreach ($kecamatan as $kecamatan => $kelurahan)
                @foreach ($kelurahan as $kelurahan => $cakadaGroup)
                    @foreach ($cakadaGroup as $cakada_name => $NamaCakada)
                        <div class="card card-style">
                            <div class="content">
                                <h3 class="text-center">Elektabilitas Calon: {{ $NamaCakada  }} </h3>
                                <p class="text-center mt-n2 mb-2 font-11 color-highlight">
                                    Provinsi: {{ $provinsi }}, Kabupaten/Kota: {{ $kabupatenKota }},
                                    Kecamatan: {{ $kecamatan }}, Kelurahan: {{ $kelurahan }}
                                </p>
                                <div class="chart-container" style="width:100%; height:350px;">
                                    <canvas class="chart" id="grafikElektabilitas_{{ $cakadaId }}"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card card-style">
                            <div class="content">
                                <h3 class="text-center">Popularitas Calon: {{ $NamaCakada  }} </h3>
                                <p class="text-center mt-n2 mb-2 font-11 color-highlight">
                                    Provinsi: {{ $provinsi }}, Kabupaten/Kota: {{ $kabupatenKota }},
                                    Kecamatan: {{ $kecamatan }}, Kelurahan: {{ $kelurahan }}
                                </p>
                                <div class="chart-container" style="width:100%; height:350px;">
                                    <canvas class="chart" id="grafikPopularitas_{{ $cakadaId }}"></canvas>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            @endforeach
        @endforeach
    @endforeach

    <script>
        if ($('.chart').length > 0) {
            var loadJS = function(url, implementationCode, location) {
                var scriptTag = document.createElement('script');
                scriptTag.src = url;
                scriptTag.onload = implementationCode;
                scriptTag.onreadystatechange = implementationCode;
                location.appendChild(scriptTag);
            };

            var call_charts_to_page = function() {
                @foreach ($elektabilitasData as $provinsi => $kabupaten)
                    @foreach ($kabupaten as $kabupatenKota => $kecamatan)
                        @foreach ($kecamatan as $kecamatan => $kelurahan)
                            @foreach ($kelurahan as $kelurahan => $cakadaGroup)
                                @foreach ($cakadaGroup as $cakadaId => $items)
                                    var ChartElektabilitas{{ $cakadaId }} = $('#grafikElektabilitas_{{ $cakadaId }}');
                                    var ChartPopularitas{{ $cakadaId }} = $('#grafikPopularitas_{{ $cakadaId }}');

                                    if (ChartElektabilitas{{ $cakadaId }}.length) {
                                        var elektabilitasChart{{ $cakadaId }} = new Chart(ChartElektabilitas{{ $cakadaId }}, {
                                            type: 'bar',
                                            data: {
                                                labels: ['Memilih', 'Tidak Memilih', 'Ragu-ragu'],
                                                datasets: [{
                                                    label: 'Elektabilitas',
                                                    backgroundColor: ['#A0D468', '#4A89DC', '#FFCE56'],
                                                    data: [
                                                        @json($items->sum('setuju')),
                                                        @json($items->sum('tidak_setuju')),
                                                        @json($items->sum('ragu_ragu'))
                                                    ],
                                                }]
                                            },
                                            options: {
                                                responsive: true,
                                                maintainAspectRatio: false,
                                                scales: {
                                                    y: {
                                                        beginAtZero: true,
                                                        title: {
                                                            display: true,
                                                            text: 'Jumlah'
                                                        }
                                                    },
                                                    x: {
                                                        title: {
                                                            display: true,
                                                            text: 'Elektabilitas'
                                                        }
                                                    }
                                                },
                                                plugins: {
                                                    legend: {
                                                        display: true,
                                                        position: 'bottom',
                                                        labels: {
                                                            fontSize: 13,
                                                            padding: 15,
                                                            boxWidth: 12
                                                        }
                                                    }
                                                }
                                            }
                                        });
                                    }

                                    if (ChartPopularitas{{ $cakadaId }}.length) {
                                        var popularitasChart{{ $cakadaId }} = new Chart(ChartPopularitas{{ $cakadaId }}, {
                                            type: 'bar',
                                            data: {
                                                labels: ['Kenal', 'Tidak Kenal'],
                                                datasets: [{
                                                    label: 'Popularitas',
                                                    backgroundColor: ['#FF6384', '#36A2EB'],
                                                    data: [
                                                        @json($items->sum('kenal')),
                                                        @json($items->sum('tidak_kenal'))
                                                    ],
                                                }]
                                            },
                                            options: {
                                                responsive: true,
                                                maintainAspectRatio: false,
                                                scales: {
                                                    y: {
                                                        beginAtZero: true,
                                                        title: {
                                                            display: true,
                                                            text: 'Jumlah'
                                                        }
                                                    },
                                                    x: {
                                                        title: {
                                                            display: true,
                                                            text: 'Popularitas'
                                                        }
                                                    }
                                                },
                                                plugins: {
                                                    legend: {
                                                        display: true,
                                                        position: 'bottom',
                                                        labels: {
                                                            fontSize: 13,
                                                            padding: 15,
                                                            boxWidth: 12
                                                        }
                                                    }
                                                }
                                            }
                                        });
                                    }
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            };

            loadJS('https://cdn.jsdelivr.net/npm/chart.js', call_charts_to_page, document.body);
        }
    </script>
@endsection
