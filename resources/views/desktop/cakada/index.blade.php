@extends('layouts.app')

@section('content')
    <h1>{{ isset($cakada) ? 'Edit Cakada' : 'Tambah Cakada' }}</h1>

    <!-- Menampilkan pesan sukses -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Tambah/Edit Cakada -->
    <div class="card mb-4">
        <div class="card-header">
            {{ isset($cakada) ? 'Edit Cakada' : 'Tambah Cakada' }}
        </div>
        <div class="card-body">
            @if (isset($cakada))
                <form action="{{ route('cakada.update', $cakada->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                @else
                    <form action="{{ route('cakada.store') }}" method="POST">
                        @csrf
            @endif
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

            <div class="mb-3">
                <label for="kabupaten_kota" class="form-label">Kabupaten/Kota</label>
                <select name="kabupaten_kota" id="kabupaten_kota" class="form-control" required>
                    <option value="">Pilih Kabupaten/Kota</option>
                    <!-- Options will be populated by JavaScript -->
                </select>
            </div>
            <div class="mb-3">
                <label for="nama_calon_kepala" class="form-label">Nama Calon Kepala</label>
                <input type="text" name="nama_calon_kepala" id="nama_calon_kepala" class="form-control"
                    value="{{ isset($cakada) ? $cakada->nama_calon_kepala : '' }}" required>
            </div>
            <div class="mb-3">
                <label for="nama_calon_wakil" class="form-label">Nama Calon Wakil</label>
                <input type="text" name="nama_calon_wakil" id="nama_calon_wakil" class="form-control"
                    value="{{ isset($cakada) ? $cakada->nama_calon_wakil : '' }}" required>
            </div>
            <button type="submit" class="btn btn-primary">{{ isset($cakada) ? 'Update' : 'Tambah' }}</button>
            </form>
        </div>
    </div>

    <!-- Tabel Daftar Cakada -->
    <h2>Daftar Cakada</h2>
    <div class="card mb-4">
        <div class="card-header">Daftar Cakada</div>
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
                    @forelse ($cakadas as $cakada)
                        <tr>
                            <td>{{ $cakada->id }}</td>
                            <td>{{ $cakada->provinsi }}</td>
                            <td>{{ $cakada->kabupaten_kota }}</td>
                            <td>{{ $cakada->nama_calon_kepala }}</td>
                            <td>{{ $cakada->nama_calon_wakil }}</td>
                            <td>
                                <!-- Tombol Edit -->
                                <a href="{{ route('cakada.index', ['cakada' => $cakada->id]) }}"
                                    class="btn btn-warning btn-sm">Edit</a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('cakada.destroy', $cakada->id) }}" method="POST"
                                    style="display:inline;">
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
            // Event change pada Provinsi
            $('#provinsi').on('change', function() {
                var provinsi_id = $(this).val();
                if (provinsi_id) {
                    $.ajax({
                        url: '/get-kabupaten/' + provinsi_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#kabupaten_kota').empty().append(
                                '<option value="">Pilih Kabupaten/Kota</option>');
                            $.each(data, function(key, value) {
                                $('#kabupaten_kota').append('<option value="' + value
                                    .id + '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#kabupaten_kota').empty();
                }
            });
        });
    </script>
@endsection
