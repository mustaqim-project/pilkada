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
        </div>
        <div class="card header-card shape-rounded" data-card-height="150">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
        </div>

        <form method="POST" action="{{ route('kanvasing.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="card card-style">
                <div class="content mb-0 mt-1">
                    <!-- Provinsi -->
                    <div class="input-style has-icon input-style-1 input-required">
                        <i class="input-icon fa fa-map-marker color-theme"></i>
                        <span>Provinsi</span>
                        <select name="provinsi" id="provinsi" class="input" required>
                            <option value="">Pilih Provinsi</option>
                            @foreach ($provinsi as $prov)
                                <option value="{{ $prov['id'] }}">{{ $prov['name'] }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('provinsi')" class="mt-2" />
                    </div>

                    <!-- Kabupaten/Kota -->
                    <div class="input-style has-icon input-style-1 input-required mt-4">
                        <i class="input-icon fa fa-building color-theme"></i>
                        <span>Kabupaten/Kota</span>
                        <select name="kabupaten_kota" id="kabupaten_kota" class="input" required>
                            <option value="">Pilih Kabupaten/Kota</option>
                            <!-- Options will be populated by JavaScript -->
                        </select>
                        <x-input-error :messages="$errors->get('kabupaten_kota')" class="mt-2" />
                    </div>

                    <!-- Kecamatan -->
                    <div class="input-style has-icon input-style-1 input-required mt-4">
                        <i class="input-icon fa fa-home color-theme"></i>
                        <span>Kecamatan</span>
                        <select name="kecamatan" id="kecamatan" class="input" required>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                        <x-input-error :messages="$errors->get('kecamatan')" class="mt-2" />
                    </div>

                    <!-- Kelurahan -->
                    <div class="input-style has-icon input-style-1 input-required mt-4">
                        <i class="input-icon fa fa-village color-theme"></i>
                        <span>Kelurahan</span>
                        <select name="kelurahan" id="kelurahan" class="input" required>
                            <option value="">Pilih Kelurahan</option>
                        </select>
                        <x-input-error :messages="$errors->get('kelurahan')" class="mt-2" />
                    </div>

                    <!-- RW -->
                    <div class="input-style has-icon input-style-1 input-required mt-4">
                        <i class="input-icon fa fa-ruler color-theme"></i>
                        <span>RW</span>
                        <x-text-input id="rw" class="input" type="text" name="rw" :value="old('rw')" required
                            placeholder="RW" />
                        <x-input-error :messages="$errors->get('rw')" class="mt-2" />
                    </div>

                    <!-- RT -->
                    <div class="input-style has-icon input-style-1 input-required mt-4">
                        <i class="input-icon fa fa-ruler color-theme"></i>
                        <span>RT</span>
                        <x-text-input id="rt" class="input" type="text" name="rt" :value="old('rt')" required
                            placeholder="RT" />
                        <x-input-error :messages="$errors->get('rt')" class="mt-2" />
                    </div>

                    <!-- Cakada ID -->
                    <div class="input-style has-icon input-style-1 input-required mt-4">
                        <i class="input-icon fa fa-id-card color-theme"></i>
                        <span>Cakada ID</span>
                        <x-text-input id="cakada_id" class="input" type="number" name="cakada_id" :value="old('cakada_id')"
                            required placeholder="Cakada ID" />
                        <x-input-error :messages="$errors->get('cakada_id')" class="mt-2" />
                    </div>

                    <!-- Profile Picture Upload -->
                    <div class="mt-4">
                        <img id="image_preview" src="#" alt="Image Preview" style="display:none;" />
                    </div>
                    <div class="file-data">
                        <input type="file" id="foto" name="foto"
                            class="upload-file bg-highlight shadow-s rounded-s" accept="image/*">
                        <p class="upload-file-text color-white">Upload Image</p>
                        <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                    </div>

                    <!-- Elektabilitas -->
                    <div class="input-style has-icon input-style-1 input-required mt-4">
                        <i class="input-icon fa fa-bar-chart color-theme"></i>
                        <span>Elektabilitas</span>
                        <x-text-input id="elektabilitas" class="input" type="number" step="0.01" name="elektabilitas"
                            :value="old('elektabilitas')" required placeholder="Elektabilitas" />
                        <x-input-error :messages="$errors->get('elektabilitas')" class="mt-2" />
                    </div>

                    <!-- Popularitas -->
                    <div class="input-style has-icon input-style-1 input-required mt-4">
                        <i class="input-icon fa fa-bar-chart color-theme"></i>
                        <span>Popularitas</span>
                        <x-text-input id="popularitas" class="input" type="number" step="0.01" name="popularitas"
                            :value="old('popularitas')" required placeholder="Popularitas" />
                        <x-input-error :messages="$errors->get('popularitas')" class="mt-2" />
                    </div>

                    <!-- Alamat -->
                    <div class="input-style has-icon input-style-1 input-required mt-4">
                        <i class="input-icon fa fa-address-card color-theme"></i>
                        <span>Alamat</span>
                        <x-text-input id="alamat" class="input" type="text" name="alamat" :value="old('alamat')"
                            required placeholder="Alamat" />
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>

                    <!-- Nama KK -->
                    <div class="input-style has-icon input-style-1 input-required mt-4">
                        <i class="input-icon fa fa-user color-theme"></i>
                        <span>Nama KK</span>
                        <x-text-input id="nama_kk" class="input" type="text" name="nama_kk" :value="old('nama_kk')"
                            required placeholder="Nama KK" />
                        <x-input-error :messages="$errors->get('nama_kk')" class="mt-2" />
                    </div>

                    <!-- Nomor HP -->
                    <div class="input-style has-icon input-style-1 input-required mt-4">
                        <i class="input-icon fa fa-phone color-theme"></i>
                        <span>Nomor HP</span>
                        <x-text-input id="nomor_hp" class="input" type="text" name="nomor_hp" :value="old('nomor_hp')"
                            required placeholder="Nomor HP" />
                        <x-input-error :messages="$errors->get('nomor_hp')" class="mt-2" />
                    </div>

                    <!-- Jumlah Pemilih -->
                    <div class="input-style has-icon input-style-1 input-required mt-4">
                        <i class="input-icon fa fa-users color-theme"></i>
                        <span>Jumlah Pemilih</span>
                        <x-text-input id="jum_pemilih" class="input" type="number" name="jum_pemilih"
                            :value="old('jum_pemilih')" required placeholder="Jumlah Pemilih" />
                        <x-input-error :messages="$errors->get('jum_pemilih')" class="mt-2" />
                    </div>
                    <!-- Lokasi Saya -->
                    <div class="input-style has-icon input-style-1 mt-4">
                        <i class="input-icon fa fa-map-pin color-theme"></i>
                        <span>Lokasi Saya</span>
                        <x-text-input id="location_name" class="input" type="text" name="location_name" readonly
                            :value="old('location_name')" placeholder="Lokasi Saya" />
                        <x-input-error :messages="$errors->get('location_name')" class="mt-2" />
                    </div>

                    <!-- Latitude and Longitude -->
                    <input type="hidden" id="lat" name="lat">
                    <input type="hidden" id="long" name="long">

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-full btn-highlight">Simpan</button>

                </div>
            </div>

        </form>
        <!-- Leaflet Map -->
        <div id="map" style="height: 400px; width: 100%; margin-top: 20px;"></div>

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
                    url: `/get-kabupaten-kota/${provinsiId}`,
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
@endsection
