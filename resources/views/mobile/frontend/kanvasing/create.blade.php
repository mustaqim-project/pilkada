@extends('mobile.frontend.layout.master')

@section('content')
<style>
    #image_preview {
        max-width: 100%; /* Atur lebar maksimal gambar */
        height: auto; /* Jaga agar proporsi gambar tetap */
        display: block; /* Tampilkan gambar secara blok */
        margin-top: 10px; /* Jarak atas */
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

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <div class="card card-style">
            <div class="content mb-0 mt-1">
                <!-- Name -->
                <div class="input-style has-icon input-style-1 input-required">
                    <i class="input-icon fa fa-user color-theme"></i>
                    <span>Name</span>
                    <x-text-input id="name" class="input" type="text" name="name" :value="old('name')" required
                        autofocus autocomplete="name" placeholder="Name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Username -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-user color-theme"></i>
                    <span>Username</span>
                    <x-text-input id="username" class="input" type="text" name="username" :value="old('username')" required
                        autofocus autocomplete="username" placeholder="Username" />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-at color-theme"></i>
                    <span>Email</span>
                    <x-text-input id="email" class="input" type="email" name="email" :value="old('email')"
                        required autocomplete="email" placeholder="Email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>



                <!-- Tanggal Lahir -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-calendar color-theme"></i>
                    <span>Tanggal Lahir</span>
                    <x-text-input id="tanggal_lahir" class="input" type="date" name="tanggal_lahir"
                        :value="old('tanggal_lahir')" required autocomplete="bday" />
                    <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                </div>

                <!-- Tinggi Badan -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-ruler-vertical color-theme"></i>
                    <span>Tinggi Badan (cm)</span>
                    <x-text-input id="tinggi_badan" class="input" type="number" name="tinggi_badan" :value="old('tinggi_badan')"
                        required autocomplete="height" placeholder="Tinggi Badan" step="any" />
                    <x-input-error :messages="$errors->get('tinggi_badan')" class="mt-2" />
                </div>

                <!-- Berat Badan -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-weight color-theme"></i>
                    <span>Berat Badan (kg)</span>
                    <x-text-input id="berat_badan" class="input" type="number" name="berat_badan" :value="old('berat_badan')"
                        required autocomplete="weight" placeholder="Berat Badan" step="any" />
                    <x-input-error :messages="$errors->get('berat_badan')" class="mt-2" />
                </div>

                <!-- Jenis Kelamin -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <span>Jenis Kelamin</span>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="input">
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                </div>

                <!-- Aktifitas -->
                <div class="input-style has-icon input-style-1 mt-4">
                    <span>Pilih Aktifitas</span>
                    <select id="aktifitas_id" name="aktifitas_id" class="input">
                        <option value="">Pilih Aktifitas</option>
                        @foreach ($aktifitas as $id => $nama)
                            <option value="{{ $id }}" {{ old('aktifitas_id') == $id ? 'selected' : '' }}>
                                {{ $nama }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('aktifitas_id')" class="mt-2" />
                </div>

                <!-- Profile Picture Upload -->
                    <div class="mt-4">
                        <img id="image_preview" src="#" alt="Image Preview"
                            style="display:none; width:200px; height:auto;" />
                    </div>
                    <div class="file-data">
                        <input type="file"  id="profile_picture" name="profile_picture" class="upload-file bg-highlight shadow-s rounded-s " accept="image/*">
                        <p class="upload-file-text color-white">Upload Image</p>
                        <x-input-error :messages="$errors->get('profile_picture')" class="mt-2" />
                    </div>

                <!-- Image Preview -->


                    <!-- Password -->
                    <div class="input-style has-icon input-style-1 input-required mt-4">
                        <i class="input-icon fa fa-lock color-theme"></i>
                        <span>Password</span>
                        <x-text-input id="password" class="input" type="password" name="password" required
                            autocomplete="new-password" placeholder="Choose a Password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="input-style has-icon input-style-1 input-required mb-4">
                        <i class="input-icon fa fa-lock color-theme"></i>
                        <span>Confirm Password</span>
                        <x-text-input id="password_confirmation" class="input" type="password" name="password_confirmation"
                            required autocomplete="new-password" placeholder="Confirm your Password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-m btn-full rounded-sm shadow-l bg-green1-dark text-uppercase font-900">
                    Create Account
                </button>

                <!-- Divider -->
                <div class="divider"></div>

                <!-- Sign-in Link -->
                <p class="text-center">
                    <a href="{{ route('login') }}" class="color-highlight opacity-80 font-12">Already Registered? Sign
                        in
                        Here</a>
                </p>

            </div>
        </div>
    </form>
</div>

<script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
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
            switch(error.code) {
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
