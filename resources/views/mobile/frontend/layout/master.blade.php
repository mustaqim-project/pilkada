<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title>Sidaksis</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('mobile/styles/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('mobile/styles/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('mobile/fonts/css/fontawesome-all.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900|Roboto:300,300i,400,400i,500,500i,700,700i,900,900i&amp;display=swap" rel="stylesheet">
    <link rel="manifest" href="{{ asset('mobile/_manifest.json') }}" data-pwa-version="set_in_manifest_and_pwa_js">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('mobile/images/logobulat.png') }}">
    <link rel="icon" href="{{ asset('mobile/images/logobulat.png') }}" type="image/png">

</head>

<body class="theme-light" data-highlight="green3">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">
        @include('mobile.components.header')
        @include('mobile.components.footer-bar')


        @yield('content')



       <div id="menu-share" class="menu menu-box-bottom menu-box-detached rounded-m" data-menu-height="420" data-menu-effect="menu-over">
            @include('mobile.frontend.dashboard.menu-share')
        </div>

        <div id="menu-highlights" class="menu menu-box-bottom menu-box-detached rounded-m" data-menu-height="510" data-menu-effect="menu-over">
            @include('mobile.frontend.dashboard.menu-colors')
        </div>

        <div id="menu-main" class="menu menu-box-right menu-box-detached rounded-m" data-menu-width="260" data-menu-active="nav-welcome" data-menu-effect="menu-over">
            @include('mobile.frontend.dashboard.menu-main')
        </div>

        <!-- Be sure this is on your main visiting page, for example, the index page -->
        <!-- Install Prompt for Android -->
        <div id="menu-install-pwa-android" class="menu menu-box-bottom menu-box-detached rounded-l" data-menu-height="350" data-menu-effect="menu-parallax">
            <div class="boxed-text-l mt-4">
                <img class="rounded-l mb-3" src="{{ asset('mobile/images/logo.png') }}" alt="img" width="90">
                <h4 class="mt-3">Sidaksis on your Home Screen</h4>
                <p>Install Sidaksis on your home screen, and access it just like a regular app. It really is that simple!</p>
                <a href="#" class="pwa-install btn btn-s rounded-s shadow-l text-uppercase font-900 bg-highlight mb-2">Add to Home Screen</a><br>
                {{-- <a href="#" class="pwa-dismiss close-menu color-gray2-light text-uppercase font-900 opacity-60 font-10">Maybe later</a> --}}
                <div class="clear"></div>
            </div>
        </div>

        <!-- Install instructions for iOS -->
        <div id="menu-install-pwa-ios" class="menu menu-box-bottom menu-box-detached rounded-l" data-menu-height="320" data-menu-effect="menu-parallax">
            <div class="boxed-text-xl mt-4">
                <img class="rounded-l mb-3" src="{{ asset('mobile/images/logo.png') }}" alt="img" width="90">
                <h4 class="mt-3">Sidaksis on your Home Screen</h4>
                <p class="mb-0 pb-3">Install Sidaksis on your home screen, and access it just like a regular app. Open your Safari menu and tap "Add to Home Screen".</p>
                <div class="clear"></div>
                {{-- <a href="#" class="pwa-dismiss close-menu color-highlight font-800 opacity-80 text-center text-uppercase">Maybe later</a><br> --}}
                <i class="fa-ios-arrow fa fa-caret-down font-40"></i>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('mobile/scripts/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mobile/scripts/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mobile/scripts/custom.js') }}"></script>

<script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>
<script>
    $(document).ready(function() {

        $('.get-location').on('click', function(e) {
            e.preventDefault(); // Prevent the default anchor click behavior

            // Jalankan fungsi pertama: getLocation()
            getLocation();

        });

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

        // Profile picture preview
        const profilePictureInput = $('#foto');
        const imagePreview = $('#image_preview');

        profilePictureInput.on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.attr('src', e.target.result).show();
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.attr('src', '#').hide();
            }
        });

        // Load Kabupaten/Kota based on Provinsi
        $('#provinsi').change(function() {
            const provinsiId = $(this).val();
            $.ajax({
                url: `/get-kabupaten/${provinsiId}`
                , method: 'GET'
                , success: function(data) {
                    $('#kabupaten_kota').empty().append('<option value="">Pilih Kabupaten/Kota</option>');
                    $.each(data, function(index, item) {
                        $('#kabupaten_kota').append(`<option value="${item.id}">${item.name}</option>`);
                    });
                    $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
                    $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
                }
            });
        });

        // Load Kecamatan based on Kabupaten/Kota
        $('#kabupaten_kota').change(function() {
            const kabupatenKotaId = $(this).val();
            $.ajax({
                url: `/get-kecamatan/${kabupatenKotaId}`
                , method: 'GET'
                , success: function(data) {
                    $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
                    $.each(data, function(index, item) {
                        $('#kecamatan').append(`<option value="${item.id}">${item.name}</option>`);
                    });
                    $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
                }
            });
        });

        // Load Kelurahan based on Kecamatan
        $('#kecamatan').change(function() {
            const kecamatanId = $(this).val();
            $.ajax({
                url: `/get-kelurahan/${kecamatanId}`
                , method: 'GET'
                , success: function(data) {
                    $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
                    $.each(data, function(index, item) {
                        $('#kelurahan').append(`<option value="${item.id}">${item.name}</option>`);
                    });
                }
            });
        });

        $('#provinsi, #kabupaten_kota, #tipe_cakada_id').change(function() {
            let provinsi = $('#provinsi').val();
            let kabupatenKota = $('#kabupaten_kota').val();
            let tipeCakada = $('#tipe_cakada_id').val();

            $.ajax({
                url: "{{ route('getCakadaByFilters') }}"
                , method: 'GET'
                , data: {
                    provinsi: provinsi
                    , kabupaten_kota: kabupatenKota
                    , tipe_cakada_id: tipeCakada
                }
                , success: function(response) {
                    let options = '<option value="">Pilih Nama Kandidat</option>';
                    $.each(response, function(index, cakada) {
                        options += `<option value="${cakada.id}">${cakada.nama_calon_kepala}-${cakada.nama_calon_wakil}</option>`;
                    });
                    $('#cakada_id').html(options);
                }
            });
        });

    });

</script>
</body>
</html>
