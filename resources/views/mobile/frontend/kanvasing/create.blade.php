<!DOCTYPE html>
<html>
<head>
    <title>Create Kanvasing Entry with Map</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin=""/>
    <style>
        #map {
            height: 300px;
            width: 100%;
        }
        .container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create Kanvasing Entry</h1>
        <form action="{{ route('kanvasing.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Provinsi -->
            <div class="form-group">
                <label for="provinsi">Provinsi</label>
                <select name="provinsi" id="provinsi" class="form-control" required>
                    <option value="">Pilih Provinsi</option>
                    @foreach($provinsi as $prov)
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

            <!-- RW, RT, Foto -->
            <div class="form-group">
                <label for="rw">RW</label>
                <input type="text" name="rw" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="rt">RT</label>
                <input type="text" name="rt" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="cakada_id">Cakada ID:</label>
                <input type="number" id="cakada_id" name="cakada_id" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="foto">Foto:</label>
                <input type="file" id="foto" name="foto" class="form-control">
            </div>

            <div class="form-group">
                <label for="elektabilitas">Elektabilitas:</label>
                <input type="number" step="0.01" id="elektabilitas" name="elektabilitas" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="popularitas">Popularitas:</label>
                <input type="number" step="0.01" id="popularitas" name="popularitas" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <input type="text" id="alamat" name="alamat" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="nama_kk">Nama KK:</label>
                <input type="text" id="nama_kk" name="nama_kk" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="nomor_hp">Nomor HP:</label>
                <input type="text" id="nomor_hp" name="nomor_hp" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="jum_pemilih">Jumlah Pemilih:</label>
                <input type="number" id="jum_pemilih" name="jum_pemilih" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="location_name">Lokasi Saya:</label>
                <input type="text" id="location_name" name="location_name" class="form-control" readonly>
            </div>

            <input type="hidden" id="lat" name="lat">
            <input type="hidden" id="long" name="long">

            <button type="submit" class="btn btn-primary">Create</button>
        </form>

        <!-- Leaflet Map -->
        <div id="map"></div>
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
                .bindPopup('Lokasi Saya')
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


        const profilePictureInput = document.getElementById('foto');
        const imagePreview = document.getElementById('image_preview');

        profilePictureInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '#';
                imagePreview.style.display = 'none';
            }
        });




        // Load Kabupaten/Kota based on Provinsi
        $('#provinsi').change(function() {
            const provinsiId = $(this).val();
            $.ajax({
                url: `/get-kabupaten/${provinsiId}`,
                method: 'GET',
                success: function(data) {
                    $('#kabupaten_kota').empty().append(
                        '<option value="">Pilih Kabupaten/Kota</option>');
                    $.each(data, function(index, item) {
                        $('#kabupaten_kota').append(
                            `<option value="${item.id}">${item.name}</option>`);
                    });
                    $('#kecamatan').empty().append(
                        '<option value="">Pilih Kecamatan</option>');
                    $('#kelurahan').empty().append(
                        '<option value="">Pilih Kelurahan</option>');
                }
            });
        });

        // Load Kecamatan based on Kabupaten/Kota
        $('#kabupaten_kota').change(function() {
            const kabupatenKotaId = $(this).val();
            $.ajax({
                url: `/get-kecamatan/${kabupatenKotaId}`,
                method: 'GET',
                success: function(data) {
                    $('#kecamatan').empty().append(
                        '<option value="">Pilih Kecamatan</option>');
                    $.each(data, function(index, item) {
                        $('#kecamatan').append(
                            `<option value="${item.id}">${item.name}</option>`);
                    });
                    $('#kelurahan').empty().append(
                        '<option value="">Pilih Kelurahan</option>');
                }
            });
        });

        // Load Kelurahan based on Kecamatan
        $('#kecamatan').change(function() {
            const kecamatanId = $(this).val();
            $.ajax({
                url: `/get-kelurahan/${kecamatanId}`,
                method: 'GET',
                success: function(data) {
                    $('#kelurahan').empty().append(
                        '<option value="">Pilih Kelurahan</option>');
                    $.each(data, function(index, item) {
                        $('#kelurahan').append(
                            `<option value="${item.id}">${item.name}</option>`);
                    });
                }
            });
        });

    });
</script>
</body>
</html>
