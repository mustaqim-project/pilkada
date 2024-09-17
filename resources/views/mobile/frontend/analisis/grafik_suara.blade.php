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

    <div id="grafik-container"></div> <!-- Container for dynamic content -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Function to load and render charts
            function renderCharts(data) {
                const container = document.getElementById('grafik-container');
                container.innerHTML = '';

                Object.keys(data.elektabilitasData).forEach(provinsi => {
                    Object.keys(data.elektabilitasData[provinsi]).forEach(kabupatenKota => {
                        Object.keys(data.elektabilitasData[provinsi][kabupatenKota]).forEach(kecamatan => {
                            Object.keys(data.elektabilitasData[provinsi][kabupatenKota][kecamatan]).forEach(kelurahan => {
                                Object.keys(data.elektabilitasData[provinsi][kabupatenKota][kecamatan][kelurahan]).forEach(cakadaId => {
                                    const items = data.elektabilitasData[provinsi][kabupatenKota][kecamatan][kelurahan][cakadaId];

                                    container.innerHTML += `
                                        <div class="card card-style">
                                            <div class="content">
                                                <h3 class="text-center">Elektabilitas Calon: ${items[0].cakada_name}</h3>
                                                <p class="text-center mt-n2 mb-2 font-11 color-highlight">
                                                    Provinsi: ${provinsi}, Kabupaten/Kota: ${kabupatenKota}, Kecamatan: ${kecamatan}, Kelurahan: ${kelurahan}
                                                </p>
                                                <div class="chart-container" style="width:100%; height:350px;">
                                                    <canvas class="chart" id="grafikElektabilitas_${cakadaId}"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-style">
                                            <div class="content">
                                                <h3 class="text-center">Popularitas Calon: ${items[0].cakada_name}</h3>
                                                <p class="text-center mt-n2 mb-2 font-11 color-highlight">
                                                    Provinsi: ${provinsi}, Kabupaten/Kota: ${kabupatenKota}, Kecamatan: ${kecamatan}, Kelurahan: ${kelurahan}
                                                </p>
                                                <div class="chart-container" style="width:100%; height:350px;">
                                                    <canvas class="chart" id="grafikPopularitas_${cakadaId}"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    `;

                                    const elektabilitasData = [
                                        items.reduce((sum, item) => sum + item.setuju, 0),
                                        items.reduce((sum, item) => sum + item.tidak_setuju, 0),
                                        items.reduce((sum, item) => sum + item.ragu_ragu, 0),
                                    ];

                                    const popularitasData = [
                                        items.reduce((sum, item) => sum + item.kenal, 0),
                                        items.reduce((sum, item) => sum + item.tidak_kenal, 0),
                                    ];

                                    new Chart(document.getElementById(`grafikElektabilitas_${cakadaId}`), {
                                        type: 'bar',
                                        data: {
                                            labels: ['Memilih', 'Tidak Memilih', 'Ragu-ragu'],
                                            datasets: [{
                                                label: 'Elektabilitas',
                                                backgroundColor: ['#A0D468', '#4A89DC', '#FFCE56'],
                                                data: elektabilitasData,
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                    title: { display: true, text: 'Jumlah' }
                                                },
                                                x: {
                                                    title: { display: true, text: 'Elektabilitas' }
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

                                    new Chart(document.getElementById(`grafikPopularitas_${cakadaId}`), {
                                        type: 'bar',
                                        data: {
                                            labels: ['Kenal', 'Tidak Kenal'],
                                            datasets: [{
                                                label: 'Popularitas',
                                                backgroundColor: ['#FF6384', '#36A2EB'],
                                                data: popularitasData,
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                    title: { display: true, text: 'Jumlah' }
                                                },
                                                x: {
                                                    title: { display: true, text: 'Popularitas' }
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
                                });
                            });
                        });
                    });
                });
            }

            // Fetch data from endpoint and render charts
            fetch('/get-grafik-suara')
                .then(response => response.json())
                .then(data => {
                    renderCharts(data);
                })
                .catch(error => console.error('Error fetching data:', error));
        });
    </script>
@endsection
