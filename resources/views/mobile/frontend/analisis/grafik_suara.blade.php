@extends('mobile.frontend.layout.master')


@section('content')

<div class="container">
    <h2>Grafik Suara</h2>

    <!-- Filter Form -->
    <div class="row">
        <div class="col-md-4">
            <label for="provinsi">Provinsi</label>
            <select id="provinsi" class="form-control">
                <option value="">Pilih Provinsi</option>
                <!-- Option Provinsi akan diisi melalui JavaScript -->
            </select>
        </div>
        <div class="col-md-4">
            <label for="kabupaten_kota">Kabupaten/Kota</label>
            <select id="kabupaten_kota" class="form-control">
                <option value="">Pilih Kabupaten/Kota</option>
                <!-- Option Kabupaten/Kota akan diisi melalui JavaScript -->
            </select>
        </div>
        <div class="col-md-4">
            <label for="kecamatan">Kecamatan</label>
            <select id="kecamatan" class="form-control">
                <option value="">Pilih Kecamatan</option>
                <!-- Option Kecamatan akan diisi melalui JavaScript -->
            </select>
        </div>
        <div class="col-md-4 mt-3">
            <label for="kelurahan">Kelurahan</label>
            <select id="kelurahan" class="form-control">
                <option value="">Pilih Kelurahan</option>
                <!-- Option Kelurahan akan diisi melalui JavaScript -->
            </select>
        </div>
        <div class="col-md-4 mt-3">
            <label for="tipe_cakada_id">Tipe Cakada</label>
            <select id="tipe_cakada_id" class="form-control">
                <option value="">Pilih Tipe Cakada</option>
                @foreach($tipe_cakada as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 mt-3">
            <label for="cakada_id">Nama Kandidat</label>
            <select id="cakada_id" class="form-control">
                <option value="">Pilih Nama Kandidat</option>
                <!-- Option Kandidat akan diisi melalui JavaScript -->
            </select>
        </div>
    </div>

    <!-- Chart -->
    <div class="row mt-5">
        <div class="col-md-12">
            <canvas id="myChart" width="400" height="200"></canvas>
        </div>
    </div>

    <button id="filterButton" class="btn btn-primary mt-3">Tampilkan Grafik</button>

</div>

<script>
    $(document).ready(function() {
        // Populate Provinsi Dropdown
        $.ajax({
            url: 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json',
            method: 'GET',
            success: function(data) {
                let provinsiDropdown = $('#provinsi');
                data.forEach(function(provinsi) {
                    provinsiDropdown.append('<option value="' + provinsi.id + '">' + provinsi.name + '</option>');
                });
            }
        });

        // Populate Kabupaten/Kota when Provinsi changes
        $('#provinsi').change(function() {
            let provinsiId = $(this).val();
            $('#kabupaten_kota').html('<option value="">Pilih Kabupaten/Kota</option>');
            if (provinsiId) {
                $.ajax({
                    url: `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinsiId}.json`,
                    method: 'GET',
                    success: function(data) {
                        data.forEach(function(kabupaten) {
                            $('#kabupaten_kota').append('<option value="' + kabupaten.id + '">' + kabupaten.name + '</option>');
                        });
                    }
                });
            }
        });

        // Populate Kecamatan when Kabupaten/Kota changes
        $('#kabupaten_kota').change(function() {
            let kabupatenId = $(this).val();
            $('#kecamatan').html('<option value="">Pilih Kecamatan</option>');
            if (kabupatenId) {
                $.ajax({
                    url: `https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kabupatenId}.json`,
                    method: 'GET',
                    success: function(data) {
                        data.forEach(function(kecamatan) {
                            $('#kecamatan').append('<option value="' + kecamatan.id + '">' + kecamatan.name + '</option>');
                        });
                    }
                });
            }
        });

        // Populate Kelurahan when Kecamatan changes
        $('#kecamatan').change(function() {
            let kecamatanId = $(this).val();
            $('#kelurahan').html('<option value="">Pilih Kelurahan</option>');
            if (kecamatanId) {
                $.ajax({
                    url: `https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecamatanId}.json`,
                    method: 'GET',
                    success: function(data) {
                        data.forEach(function(kelurahan) {
                            $('#kelurahan').append('<option value="' + kelurahan.id + '">' + kelurahan.name + '</option>');
                        });
                    }
                });
            }
        });

        // Filter and update chart
        $('#filterButton').click(function() {
            let provinsi = $('#provinsi').val();
            let kabupaten = $('#kabupaten_kota').val();
            let kecamatan = $('#kecamatan').val();
            let kelurahan = $('#kelurahan').val();
            let tipe_cakada_id = $('#tipe_cakada_id').val();
            let cakada_id = $('#cakada_id').val();

            $.ajax({
                url: "{{ route('getGrafikSuara') }}",
                method: 'GET',
                data: {
                    provinsi: provinsi,
                    kabupaten_kota: kabupaten,
                    kecamatan: kecamatan,
                    kelurahan: kelurahan,
                    tipe_cakada_id: tipe_cakada_id,
                    cakada_id: cakada_id
                },
                success: function(response) {
                    let ctx = document.getElementById('myChart').getContext('2d');
                    let chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: response.labels,
                            datasets: [{
                                label: 'Suara',
                                data: [response.setuju, response.tidak_setuju, response.ragu_ragu],
                                backgroundColor: ['green', 'red', 'yellow']
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            });
        });
    });
</script>

@endsection
