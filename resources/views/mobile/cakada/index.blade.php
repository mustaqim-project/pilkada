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

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        });
    </script>
    @endif

    <div class="card card-style">
        <div class="content mb-2">
            <h3>Role Permission</h3>
            <a href="{{ route('role.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> {{ __('Create new') }}
            </a>
            <table class="table table-responsive text-center rounded-sm shadow-l" style="overflow: hidden;">
                <thead>
                    <tr class="bg-gray1-dark">
                        <th scope="col" class="color-theme">#</th>
                        <th scope="col" class="color-theme">Provinsi</th>
                        <th scope="col" class="color-theme">Kabupaten/Kota</th>
                        <th scope="col" class="color-theme">Nama Calon Kepala</th>
                        <th scope="col" class="color-theme">Nama Calon Wakil</th>
                        <th scope="col" class="color-theme">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Ensure `$provinsi` is treated as an array or collection
                        $provinsiMap = collect($provinsi)->pluck('name', 'id')->toArray();
                    @endphp

                    @forelse ($cakadas as $cakada)
                        @php
                            // Get the province name using the map
                            $provinsiName = $provinsiMap[$cakada->provinsi] ?? 'Unknown';

                            // Get regencies for the selected province
                            $regencies = app('App\Http\Controllers\CakadaController')->getRegencies($cakada->provinsi);
                            $regenciesMap = collect($regencies)->pluck('name', 'id')->toArray();
                            $kabupatenKotaName = $regenciesMap[$cakada->kabupaten_kota] ?? 'Unknown';
                        @endphp
                        <tr>
                            <td scope="row">{{ $cakada->id }}</td>
                            <td class="color-dark">{{ $provinsiName }}</td>
                            <td class="color-dark">{{ $kabupatenKotaName }}</td>
                            <td class="color-dark">{{ $cakada->nama_calon_kepala }}</td>
                            <td class="color-dark">{{ $cakada->nama_calon_wakil }}</td>
                            <td class="color-dark">
                                <button class="btn btn-warning btn-sm btn-edit" data-id="{{ $cakada->id }}">Edit</button>
                                <form action="{{ route('cakada.destroy', $cakada->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Load data for provinces
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

        // Load regencies based on selected province
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

        // Edit button clicked
        $('.btn-edit').click(function() {
            let id = $(this).data('id');
            $.ajax({
                url: `/cakada/${id}/edit`,
                method: 'GET',
                success: function(data) {
                    $('#modalCakada').modal('show');
                    $('#cakada_id').val(data.id);
                    $('#provinsi').val(data.provinsi);
                    $('#tipe_cakada_id').val(data.tipe_cakada_id);
                    $('#nama_calon_kepala').val(data.nama_calon_kepala);
                    $('#nama_calon_wakil').val(data.nama_calon_wakil);
                    $('#formCakada').attr('action', `/cakada/${id}`);
                    $('#formCakada').append('<input type="hidden" name="_method" value="PUT">');

                    // Trigger change event for the 'provinsi' dropdown
                    $('#provinsi').trigger('change');

                    // Delay to ensure regencies are populated before setting kabupaten_kota value
                    setTimeout(function() {
                        $('#kabupaten_kota').val(data.kabupaten_kota);
                    }, 500);
                }
            });
        });
    });
</script>

@endsection
