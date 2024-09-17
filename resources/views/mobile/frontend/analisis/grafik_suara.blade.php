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

    <div class="card card-style">
        <div class="content">
            <h3 class="text-center">Elektabilitas Calon</h3>
            <p class="text-center mt-n2 mb-2 font-11 color-highlight">Elektabilitas Berdasarkan Provinsi</p>
            <div class="chart-container" style="width:100%; height:350px;">
                <canvas class="chart" id="grafikElektabilitas"></canvas>
            </div>
        </div>
    </div>

    <div class="card card-style">
        <div class="content">
            <h3 class="text-center">Popularitas Calon</h3>
            <p class="text-center mt-n2 mb-2 font-11 color-highlight">Popularitas Berdasarkan Provinsi</p>
            <div class="chart-container" style="width:100%; height:350px;">
                <canvas class="chart" id="grafikPopularitas"></canvas>
            </div>
        </div>
    </div>

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
                var ChartElektabilitas = $('#grafikElektabilitas');
                var ChartPopularitas = $('#grafikPopularitas');

                if (ChartElektabilitas.length) {
                    var elektabilitasChart = new Chart(ChartElektabilitas, {
                        type: 'bar',
                        data: {
                            labels: @json($data->pluck('provinsi_name')->unique()),
                            datasets: [
                                {
                                    label: 'Setuju',
                                    backgroundColor: '#A0D468',
                                    data: @json($data->groupBy('provinsi_name')->map(function($group) {
                                        return $group->sum('setuju');
                                    })->values()),
                                },
                                {
                                    label: 'Tidak Setuju',
                                    backgroundColor: '#4A89DC',
                                    data: @json($data->groupBy('provinsi_name')->map(function($group) {
                                        return $group->sum('tidak_setuju');
                                    })->values()),
                                },
                                {
                                    label: 'Ragu-ragu',
                                    backgroundColor: '#FFCE56',
                                    data: @json($data->groupBy('provinsi_name')->map(function($group) {
                                        return $group->sum('ragu_ragu');
                                    })->values()),
                                }
                            ]
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
                                        text: 'Provinsi'
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

                if (ChartPopularitas.length) {
                    var popularitasChart = new Chart(ChartPopularitas, {
                        type: 'bar',
                        data: {
                            labels: @json($data->pluck('provinsi_name')->unique()),
                            datasets: [
                                {
                                    label: 'Kenal',
                                    backgroundColor: '#FF6384',
                                    data: @json($data->groupBy('provinsi_name')->map(function($group) {
                                        return $group->sum('kenal');
                                    })->values()),
                                },
                                {
                                    label: 'Tidak Kenal',
                                    backgroundColor: '#36A2EB',
                                    data: @json($data->groupBy('provinsi_name')->map(function($group) {
                                        return $group->sum('tidak_kenal');
                                    })->values()),
                                }
                            ]
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
                                        text: 'Provinsi'
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
            };

            loadJS('https://cdn.jsdelivr.net/npm/chart.js', call_charts_to_page, document.body);
        }
    </script>
@endsection
