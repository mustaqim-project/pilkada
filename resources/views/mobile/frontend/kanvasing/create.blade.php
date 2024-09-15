@extends('mobile.frontend.layout.master')

@section('content')
    <style>
        #image_preview {
            max-width: 100%;
            /* Atur lebar maksimal gambar */
            height: auto;
            /* Jaga agar proporsi gambar tetap */
            display: block;
            /* Tampilkan gambar secara blok */
            margin-top: 10px;
            /* Jarak atas */
        }
    </style>
    <div class="page-content">
        <div class="page-title page-title-small">
            <h2><a href="#" data-back-button><i class="fa fa-arrow-left"></i></a>Sign Up</h2>
            </a>
        </div>
        <div class="card header-card shape-rounded" data-card-height="150">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
        </div>

        <form method="POST" action="{{ route('kanvasing.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Provinsi -->
            <div class="form-group">
                <label for="provinsi">Provinsi</label>
                <select name="provinsi" id="provinsi" class="form-control" required>
                    <option value="">Pilih Provinsi</option>
                    @foreach ($provinsi as $prov)
                        <option value="{{ $prov['id'] }}">{{ $prov['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Kabupaten/Kota -->
            <div class="form-group">
                <label for="kabupaten_kota">Kabupaten/Kota</label>
                <select name="kabupaten_kota" id="kabupaten_kota" class="form-control" required>
                    <option value="">Pilih Kabupaten/Kota</option>
                    <!-- Options will be populated by JavaScript -->
                </select>
            </div>

            <!-- Kecamatan -->
            <div class="form-group">
                <label for="kecamatan">Kecamatan</label>
                <select name="kecamatan" id="kecamatan" class="form-control" required>
                    <option value="">Pilih Kecamatan</option>
                </select>
            </div>

            <!-- Kelurahan -->
            <div class="form-group">
                <label for="kelurahan">Kelurahan</label>
                <select name="kelurahan" id="kelurahan" class="form-control" required>
                    <option value="">Pilih Kelurahan</option>
                </select>
            </div>

            <!-- RW -->
            <div class="form-group">
                <label for="rw">RW</label>
                <input type="text" name="rw" id="rw" class="form-control" required>
            </div>

            <!-- RT -->
            <div class="form-group">
                <label for="rt">RT</label>
                <input type="text" name="rt" id="rt" class="form-control" required>
            </div>

            <!-- Cakada ID -->
            <div class="form-group">
                <label for="cakada_id">Cakada ID</label>
                <input type="number" id="cakada_id" name="cakada_id" class="form-control" required>
            </div>

            <!-- Foto -->
            <div class="form-group">
                <label for="foto">Foto</label>
                <input type="file" id="foto" name="foto" class="form-control">
            </div>

            <!-- Elektabilitas -->
            <div class="form-group">
                <label for="elektabilitas">Elektabilitas</label>
                <input type="number" step="0.01" id="elektabilitas" name="elektabilitas" class="form-control" required>
            </div>

            <!-- Popularitas -->
            <div class="form-group">
                <label for="popularitas">Popularitas</label>
                <input type="number" step="0.01" id="popularitas" name="popularitas" class="form-control" required>
            </div>

            <!-- Alamat -->
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat" class="form-control" required>
            </div>

            <!-- Nama KK -->
            <div class="form-group">
                <label for="nama_kk">Nama KK</label>
                <input type="text" id="nama_kk" name="nama_kk" class="form-control" required>
            </div>

            <!-- Nomor HP -->
            <div class="form-group">
                <label for="nomor_hp">Nomor HP</label>
                <input type="text" id="nomor_hp" name="nomor_hp" class="form-control" required>
            </div>

            <!-- Jumlah Pemilih -->
            <div class="form-group">
                <label for="jum_pemilih">Jumlah Pemilih</label>
                <input type="number" id="jum_pemilih" name="jum_pemilih" class="form-control" required>
            </div>

            <!-- Lokasi Saya -->
            <div class="form-group">
                <label for="location_name">Lokasi Saya</label>
                <input type="text" id="location_name" name="location_name" class="form-control" readonly>
            </div>

            <!-- Latitude and Longitude -->
            <input type="hidden" id="lat" name="lat">
            <input type="hidden" id="long" name="long">

            <!-- Submit Button -->

            <!-- Leaflet Map -->
            <div id="map"></div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>

    </div>

    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the map
            var map = L.map('map').setView([51.505, -0.09], 13);

            // Add a tile layer (OpenStreetMap in this case)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19
            }).addTo(map);

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
                document.getElementById('lat').value = lat;
                document.getElementById('long').value = lng;

                // Center the map and add a marker for the user's location
                map.setView([lat, lng], 13);
                L.marker([lat, lng]).addTo(map)
                    .bindPopup('Your current location.')
                    .openPopup();

                // Get the location name using reverse geocoding
                fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
                    .then(response => response.json())
                    .then(data => {
                        var locationName = data.display_name;
                        document.getElementById('location_name').value = locationName;
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

            // Auto-update location when the page loads
            getLocation();
        });
    </script>
@endsection
