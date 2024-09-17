@extends('desktop.layouts.master')

@section('content')
<!--begin::Content wrapper-->
<div class="d-flex flex-column flex-column-fluid">

    {{-- BREADCRUMBS --}}
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0"> Dashboard </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted"> Calon Kepala Daerah </li>
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

            <!-- Button untuk tambah data -->
            <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#modalCakada">Tambah Cakada</button>

            <!-- Modal Tambah/Edit Cakada -->
            <div class="modal fade" id="modalCakada" tabindex="-1" aria-labelledby="modalCakadaLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCakadaLabel">Tambah/Edit Cakada</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formCakada" action="{{ route('cakada.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" id="cakada_id">
                                <div class="mb-3">
                                    <label for="provinsi" class="form-label">Provinsi</label>
                                    <select name="provinsi" id="provinsi" class="form-control" required>
                                        <option value="">Pilih Provinsi</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="kabupaten_kota" class="form-label">Kabupaten/Kota</label>
                                    <select name="kabupaten_kota" id="kabupaten_kota" class="form-control" required>
                                        <option value="">Pilih Kabupaten/Kota</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="nama_calon_kepala" class="form-label">Nama Calon Kepala</label>
                                    <input type="text" name="nama_calon_kepala" id="nama_calon_kepala" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nama_calon_wakil" class="form-label">Nama Calon Wakil</label>
                                    <input type="text" name="nama_calon_wakil" id="nama_calon_wakil" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary" id="btnSave">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Daftar Cakada -->
            <div class="card mb-4">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Provinsi</th>
                                <th>Kabupaten/Kota</th>
                                <th>Nama Calon Kepala</th>
                                <th>Nama Calon Wakil</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $provinsiMap = [];
                            foreach ($provinsi as $prov) {
                            $provinsiMap[$prov['id']] = $prov['name'];
                            }
                            @endphp

                            @forelse ($cakadas as $cakada)
                            @php
                            $provinsiName = $provinsiMap[$cakada->provinsi] ?? 'Unknown';

                            // Ambil kabupaten/kota
                            $regencies = app('App\Http\Controllers\CakadaController')->getRegencies($cakada->provinsi);
                            $regenciesMap = [];
                            foreach ($regencies as $regency) {
                            $regenciesMap[$regency['id']] = $regency['name'];
                            }
                            $kabupatenKotaName = $regenciesMap[$cakada->kabupaten_kota] ?? 'Unknown';
                            @endphp
                            <tr>
                                <td>{{ $cakada->id }}</td>
                                <td>{{ $provinsiName }}</td>
                                <td>{{ $kabupatenKotaName }}</td>
                                <td>{{ $cakada->nama_calon_kepala }}</td>
                                <td>{{ $cakada->nama_calon_wakil }}</td>
                                <td>
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

            <script>
                $(document).ready(function() {
                    // Load data untuk provinsi
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

                    // Load kabupaten/kota berdasarkan provinsi yang dipilih
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

                    // Edit button clicked
                    $('.btn-edit').click(function() {
                        let id = $(this).data('id');
                        $.ajax({
                            url: `/cakada/${id}/edit`
                            , method: 'GET'
                            , success: function(data) {
                                $('#modalCakada').modal('show');
                                $('#cakada_id').val(data.id);
                                $('#provinsi').val(data.provinsi);
                                $('#kabupaten_kota').val(data.kabupaten_kota);
                                $('#nama_calon_kepala').val(data.nama_calon_kepala);
                                $('#nama_calon_wakil').val(data.nama_calon_wakil);
                                $('#formCakada').attr('action', `/cakada/${id}`);
                                $('#formCakada').append('<input type="hidden" name="_method" value="PUT">');
                            }
                        });
                    });
                });

            </script>

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

</div>
<!--end::Content wrapper-->
@endsection
