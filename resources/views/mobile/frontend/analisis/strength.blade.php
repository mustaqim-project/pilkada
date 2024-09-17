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


    <!-- Chart -->
    <div class="card card-style">
        <div class="content">
            <h3 class="text-center">Popularitas Dan Elektabilitas</h3>
            <div class="chart-container" style="width:100%; height:350px;">
                <canvas class="chart" id="grafikStrength"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Function to dynamically load a JavaScript file
        function loadJS(url, callback) {
            var scriptTag = document.createElement('script');
            scriptTag.src = url;
            scriptTag.onload = callback;
            scriptTag.onreadystatechange = callback;
            document.body.appendChild(scriptTag);
        }

        // Filter and update chart
        let chartInstance;

        $.ajax({
            url: "{{ route('get-strength') }}"
            , method: 'GET'
            , data: {
                provinsi: provinsi
                , kabupaten_kota: kabupaten
                , kecamatan: kecamatan
                , kelurahan: kelurahan
                , tipe_cakada_id: tipeCakadaId
                , cakada_id: cakadaId
            }
            , success: function(response) {
                let ctx = document.getElementById('grafikStrength').getContext('2d');

                if (chartInstance) {
                    chartInstance.destroy(); // Destroy previous chart instance
                }

                // Labels for the x-axis (kecamatan_name)
                const labels = response.topKabupatenKotaKecamatanSetuju.map(item => item.kecamatan_name);

                // Data for the bar chart
                const dataSetuju = response.topKabupatenKotaKecamatanSetuju.map(item => item.setuju);
                const dataRaguRagu = response.topKabupatenKotaKecamatanRaguRagu.map(item => item.ragu_ragu);
                const dataKenal = response.topKabupatenKotaKecamatanPopularitasSetuju.map(item => item.setuju);
                const dataTidakKenal = dataSetuju.map((_, i) => Math.max(...[dataSetuju[i], dataRaguRagu[i], dataKenal[i]]) - Math.min(...[dataSetuju[i], dataRaguRagu[i], dataKenal[i]]));

                chartInstance = new Chart(ctx, {
                    type: 'bar'
                    , data: {
                        labels: labels
                        , datasets: [{
                                label: 'Setuju'
                                , backgroundColor: '#A0D468'
                                , data: dataSetuju
                            }
                            , {
                                label: 'Ragu-ragu'
                                , backgroundColor: '#FFCE56'
                                , data: dataRaguRagu
                            }
                            , {
                                label: 'Kenal Dengan'
                                , backgroundColor: '#FF6384'
                                , data: dataKenal
                            }
                            , {
                                label: 'Tidak Kenal'
                                , backgroundColor: '#36A2EB'
                                , data: dataTidakKenal
                            }
                        ]
                    }
                    , options: {
                        responsive: true
                        , maintainAspectRatio: false
                        , scales: {
                            y: {
                                beginAtZero: true
                                , title: {
                                    display: true
                                    , text: 'Jumlah'
                                }
                            }
                            , x: {
                                title: {
                                    display: true
                                    , text: 'Kecamatan'
                                }
                            }
                        }
                        , plugins: {
                            legend: {
                                display: true
                                , position: 'bottom'
                                , labels: {
                                    fontSize: 13
                                    , padding: 15
                                    , boxWidth: 12
                                }
                            }
                        }
                    }
                });
            }
        });

        // Load chart.js script
        loadJS('mobile/scripts/charts.js', function() {
            // Chart initialization can be placed here if needed
        });
    });

</script>


@endsection
