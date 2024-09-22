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

    .container {
        margin-top: 20px;
    }

    .btn-full {
        display: inline-block;
        width: 100%;
        padding: 0.75rem 1.5rem;
        /* Padding atas/bawah dan kiri/kanan */
        border: none;
        border-radius: 0.375rem;
        /* Radius sudut */
        font-size: 1rem;
        font-weight: bold;
        color: #fff;
        /* Warna teks putih */
        background-color: #007bff;
        /* Ganti dengan warna latar belakang sesuai kebutuhan */
        text-align: center;
        cursor: pointer;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-highlight {
        background-color: #28a745;
        /* Ganti dengan warna latar belakang highlight */
    }

    .btn-full:hover {
        background-color: #0056b3;
        /* Ganti dengan warna latar belakang saat hover */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* Bayangan saat hover */
    }

    .btn-full:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.5);
        /* Bayangan fokus */
    }

</style>
<div class="page-content">
    <div class="page-title page-title-small">
        <h2><a href="/" data-back-button><i class="fa fa-arrow-left"></i></a>Beranda</h2>
    </div>
    <div class="card header-card shape-rounded" data-card-height="210">
        <div class="card-overlay bg-highlight opacity-95"></div>
        <div class="card-overlay dark-mode-tint"></div>
        <div class="card-bg preload-img" data-src="admin/mobile/myhr/images/sikad.png"></div>
    </div>
    <form method="POST" action="{{ route('cakada.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="card card-style">
            <div class="content mb-0 mt-1">


                <!-- Provinsi -->
                <div class="input-style has-icon input-style-1 input-required">
                    <span>Provinsi</span>
                    <select name="provinsi" id="provinsi" class="input" required>
                        <option value="">Pilih Provinsi</option>
                    </select>
                    <x-input-error :messages="$errors->get('provinsi')" class="mt-2" />
                </div>

                <!-- Kabupaten/Kota -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <span>Kabupaten/Kota</span>
                    <select name="kabupaten_kota" id="kabupaten_kota" class="input" required>
                        <option value="">Pilih Kabupaten/Kota</option>
                    </select>
                    <x-input-error :messages="$errors->get('kabupaten_kota')" class="mt-2" />
                </div>


                <!-- Tipe Cakada ID -->
                <label class="mt-4">Pilkada</label>
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <select id="tipe_cakada_id" name="tipe_cakada_id" class="input" required>
                        <option value="" disabled selected>Pilih Tipe Pilkada</option>
                        @foreach ($tipe_cakada as $item)
                        <option value="{{ $item->id }}" {{ old('tipe_cakada_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('tipe_cakada_id')" class="mt-2" />
                </div>

                <!-- Cakada ID -->
                <label class="mt-4">Nama Kandidat</label>
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <select id="cakada_id" name="cakada_id" class="input" required>
                        <option value="">Pilih Nama Kandidat</option>
                        <!-- Options will be populated by JavaScript -->
                    </select>
                    <x-input-error :messages="$errors->get('cakada_id')" class="mt-2" />
                </div>
            </div>
        </div>


        <button type="submit" class="btn btn-full btn-highlight">Simpan</button>
    </form>

    <div id="map" style="display: none;"></div>

</div>

<script>
    $(document).ready(function() {


        $.ajax({
            url: 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json'
            , method: 'GET'
            , success: function(data) {
                let provinsiDropdown = $('#provinsi');
                data.forEach(function(provinsi) {
                    provinsiDropdown.append('<option value="' + provinsi.id + '">' + provinsi.name + '</option>');
                });
            }
        });

        // Load kabupaten/kota when a provinsi is selected
        $('#provinsi').change(function() {
            let provinsiId = $(this).val();
            $('#kabupaten_kota').html('<option value="">Pilih Kabupaten/Kota</option>');
            if (provinsiId) {
                $.ajax({
                    url: `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinsiId}.json`
                    , method: 'GET'
                    , success: function(data) {
                        data.forEach(function(kabupaten) {
                            $('#kabupaten_kota').append('<option value="' + kabupaten.id + '">' + kabupaten.name + '</option>');
                        });
                    }
                });
            }
        });

        // Load kecamatan when a kabupaten/kota is selected
        $('#kabupaten_kota').change(function() {
            let kabupatenId = $(this).val();
            $('#kecamatan').html('<option value="">Pilih Kecamatan</option>');
            if (kabupatenId) {
                $.ajax({
                    url: `https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kabupatenId}.json`
                    , method: 'GET'
                    , success: function(data) {
                        data.forEach(function(kecamatan) {
                            $('#kecamatan').append('<option value="' + kecamatan.id + '">' + kecamatan.name + '</option>');
                        });
                    }
                });
            }
        });

        // Load kelurahan when a kecamatan is selected
        $('#kecamatan').change(function() {
            let kecamatanId = $(this).val();
            $('#kelurahan').html('<option value="">Pilih Kelurahan</option>');
            if (kecamatanId) {
                $.ajax({
                    url: `https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecamatanId}.json`
                    , method: 'GET'
                    , success: function(data) {
                        data.forEach(function(kelurahan) {
                            $('#kelurahan').append('<option value="' + kelurahan.id + '">' + kelurahan.name + '</option>');
                        });
                    }
                });
            }
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

@endsection
