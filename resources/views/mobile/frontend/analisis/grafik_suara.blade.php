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

    <!-- Homepage Slider -->
    <div class="page-content">
        <div class="page-title page-title-small">
            <h2><a href="#" data-back-button><i class="fa fa-arrow-left"></i></a>Charts</h2>
            <a href="#" data-menu="menu-main" class="bg-fade-gray1-dark shadow-xl preload-img" data-src="images/avatars/5s.png"></a>
        </div>

        <div class="card card-style">
            <div class="content">
                <h3 class="text-center">Mobile OS</h3>
                <p class="text-center mt-n2 mb-2 font-11 color-highlight">Growth of Mobile OS 2020</p>
                <div class="chart-container" style="width:100%; height:350px;">
                    <canvas class="chart" id="vertical-chart" /></canvas>
                </div>
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
                var verticalChart = $('#grafikSuaraChart');

                if (verticalChart.length) {
                    var verticalDemoChart = new Chart(verticalChart, {
                        type: 'bar',
                        data: {
                            labels: @json($data->pluck('provinsi')),
                            datasets: [
                                {
                                    label: 'Setuju',
                                    backgroundColor: '#A0D468',
                                    data: @json($data->pluck('setuju')),
                                },
                                {
                                    label: 'Tidak Setuju',
                                    backgroundColor: '#4A89DC',
                                    data: @json($data->pluck('tidak_setuju')),
                                },
                                {
                                    label: 'Ragu-ragu',
                                    backgroundColor: '#FFCE56',
                                    data: @json($data->pluck('ragu_ragu')),
                                },
                                {
                                    label: 'Kenal',
                                    backgroundColor: '#FF6384',
                                    data: @json($data->pluck('kenal')),
                                },
                                {
                                    label: 'Tidak Kenal',
                                    backgroundColor: '#36A2EB',
                                    data: @json($data->pluck('tidak_kenal')),
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
                                },
                                title: {
                                    display: false
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
