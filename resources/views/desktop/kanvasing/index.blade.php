@extends('desktop.layouts.master')

@section('content')
<!--begin::Content wrapper-->
<div class="d-flex flex-column flex-column-fluid">

    {{-- BREADCRUMBS --}}
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0"> SIKADSIS </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted"> Kanvasing </li>
                </ul>
            </div>
        </div>
    </div>

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">

            <!-- SweetAlert Success -->
            @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success'
                    , title: 'Success'
                    , text: '{{ session('
                    success ') }}'
                    , timer: 2000
                    , showConfirmButton: false
                });

            </script>
            @endif

            <div class="card card-style">
                <div class="responsive-iframe add-iframe">
                    <iframe class="location-map" src='https://maps.google.com/?ie=UTF8&amp;ll=47.595131,-122.330414&amp;spn=0.006186,0.016512&amp;t=h&amp;z=17&amp;output=embed'></iframe>
                </div>
            </div>
            <div id="map" style="display: block; height: 400px;"></div> <!-- Make sure the map is visible -->






        <!-- Tabel Daftar Cakada -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Provinsi</th>
                                <th>Kabupaten/Kota</th>
                                <th>Kecamatan</th>
                                <th>Kelurahan</th>
                                <th>Nama KK</th>
                                <th>Nomor HP</th>
                                <th>Alamat</th>
                                <th>Elektabilitas</th>
                                <th>Popularitas</th>
                                <th>Jenis Kelamin</th>
                                <th>Usia</th>
                                <th>Jumlah Pemilih</th>
                                <th>Alasan</th>
                                <th>Pesan</th>
                                <th>Deskripsi</th>
                                <th>Foto</th>
                                <th>Long</th>
                                <th>Lat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kanvasings as $kanvasing)
                            <tr>
                                <td>{{ $kanvasing->id }}</td>
                                <td>{{ $kanvasing->provinsi_name }}</td>
                                <td>{{ $kanvasing->kabupaten_name }}</td>
                                <td>{{ $kanvasing->kecamatan_name }}</td>
                                <td>{{ $kanvasing->kelurahan_name }}</td>
                                <td>{{ $kanvasing->nama_kk }}</td>
                                <td>{{ $kanvasing->nomor_hp }}</td>
                                <td>{{ $kanvasing->alamat }}</td>
                                <!-- Translating elektabilitas -->
                                <td>
                                    @switch($kanvasing->elektabilitas)
                                    @case(1)
                                    Memilih
                                    @break
                                    @case(2)
                                    Tidak Memilih
                                    @break
                                    @case(3)
                                    Ragu-Ragu
                                    @break
                                    @default
                                    Tidak Diketahui
                                    @endswitch
                                </td>

                                <!-- Translating popularitas -->
                                <td>
                                    @switch($kanvasing->popularitas)
                                    @case(1)
                                    Kenal
                                    @break
                                    @case(2)
                                    Tidak Kenal
                                    @break
                                    @default
                                    Tidak Diketahui
                                    @endswitch
                                </td>

                                <!-- Translating jenis_kelamin -->
                                <td>
                                    @switch($kanvasing->jenis_kelamin)
                                    @case(1)
                                    Laki-laki
                                    @break
                                    @case(2)
                                    Perempuan
                                    @break
                                    @default
                                    Tidak Diketahui
                                    @endswitch
                                </td>
                                <td>{{ $kanvasing->usia }}</td>
                                <td>{{ $kanvasing->jum_pemilih }}</td>
                                <td>{{ $kanvasing->alasan }}</td>
                                <td>{{ $kanvasing->pesan }}</td>
                                <td>{{ $kanvasing->deskripsi }}</td>
                                <td>
                                    <img src="{{ asset($kanvasing->foto) }}" alt="Foto" style="width: 50px; height: auto;">
                                </td>
                                <td>{{ $kanvasing->lang }}</td>
                                <td>{{ $kanvasing->lat }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('kanvasing.edit', $kanvasing->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('kanvasing.destroy', $kanvasing->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="20" class="text-center">Tidak ada data.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>


<script>
    $(document).ready(function() {
        checkLocationPermission();

        // Extract latitude and longitude from the kanvasings data
        var locations = @json($kanvasings->map(function($kanvasing) {
            return ['lat' => $kanvasing->lat, 'lng' => $kanvasing->lang];
        }));

        // Initialize the map
        var map = L.map('map').setView([locations[0].lat, locations[0].lng], 13); // Start at the first location

        // Add a tile layer (OpenStreetMap in this case)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(map);

        // Loop through the locations and add markers to the map
        locations.forEach(function(location) {
            L.marker([location.lat, location.lng]).addTo(map)
                .bindPopup('Lat: ' + location.lat + ', Lng: ' + location.lng)
                .openPopup();
        });

        $('.get-location').on('click', function(e) {
            e.preventDefault(); // Prevent the default anchor click behavior

            // Run the function to get the user's location
            getLocation();
        });

        // Function to get the user's location and update the map
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                console.log("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;

            // Update hidden fields with user's location
            $('#lat').val(lat);
            $('#lang').val(lng);

            // Center the map and add a marker for the user's location
            map.setView([lat, lng], 13);
            L.marker([lat, lng]).addTo(map)
                .bindPopup('Lokasi Saya')
                .openPopup();

            // Get the location name using reverse geocoding
            fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
                .then(response => response.json())
                .then(data => {
                    var locationName = data.display_name;
                    $('#location_name').val(locationName);
                })
                .catch(error => console.error('Error fetching location name:', error));
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    console.log("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    console.log("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    console.log("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    console.log("An unknown error occurred.");
                    break;
            }
        }
    });
</script>
@endsection
