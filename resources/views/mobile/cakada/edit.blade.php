@extends('mobile.frontend.layout.master')

@section('content')
<div class="page-content" style="min-height:60vh!important">
    <div class="page-title page-title-small">
        <h2><a href="{{ route('dashboard') }}" data-back-button><i class="fa fa-arrow-left"></i></a>Beranda</h2>
    </div>
    <div class="card card-style">
        <div class="content mb-2">
            <form action="{{ route('cakada.update', $cakada->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="provinsi">Provinsi</label>
                    <select name="provinsi" id="provinsi" class="form-control" required>
                        <option value="">Pilih Provinsi</option>
                        @foreach ($provinsi as $item)
                            <option value="{{ $item['id'] }}" {{ $item['id'] == $cakada->provinsi ? 'selected' : '' }}>
                                {{ $item['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="kabupaten_kota">Kabupaten/Kota</label>
                    <select name="kabupaten_kota" id="kabupaten_kota" class="form-control" required>
                        <option value="">Pilih Kabupaten/Kota</option>
                        <!-- Kab. Kota akan diisi oleh AJAX -->
                    </select>
                </div>

                <!-- Input lainnya tetap sama -->

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Ambil kabupaten kota saat halaman dimuat
        let selectedProvinsiId = {{ json_encode($cakada->provinsi) }};
        let selectedKabupatenKotaId = {{ json_encode($cakada->kabupaten_kota) }};

        if (selectedProvinsiId) {
            $.ajax({
                url: `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${selectedProvinsiId}.json`,
                method: 'GET',
                success: function(data) {
                    data.forEach(function(kabupaten) {
                        $('#kabupaten_kota').append('<option value="' + kabupaten.id + '">' + kabupaten.name + '</option>');
                    });
                    // Setel kabupaten kota yang sudah ada
                    $('#kabupaten_kota').val(selectedKabupatenKotaId);
                },
                error: function() {
                    alert('Error fetching regencies. Please try again.');
                }
            });
        }

        // Trigger change untuk memuat kabupaten saat provinsi dipilih
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
                    },
                    error: function() {
                        alert('Error fetching regencies. Please try again.');
                    }
                });
            }
        });
    });
</script>

@endsection
