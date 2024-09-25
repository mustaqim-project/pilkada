@extends('desktop.layouts.master')

@section('content')
<!--begin::Content wrapper-->
<div class="d-flex flex-column flex-column-fluid">

    {{-- BREADCRUMBS --}}
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0"> SIKADSIS </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted"> Kanvasing </li>
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



            <!-- Tabel Daftar Cakada -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Provinsi</th>
                                    <th>Kabupaten/Kota</th>
                                    <th>Kecamatan</th>
                                    <th>Kelurahan</th>
                                    <th>Nama KK</th>
                                    <th>Nomor HP</th>
                                    <th>Alamat</th>
                                    <th>Elektabilitas</th>
                                    <th>Popularitas</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Usia</th>
                                    <th>Jumlah Pemilih</th>
                                    <th>Alasan</th>
                                    <th>Pesan</th>
                                    <th>Deskripsi</th>
                                    <th>Foto</th>
                                    <th>Long</th>
                                    <th>Lat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kanvasings as $kanvasing)
                                <tr>
                                    <td>{{ $kanvasing->id }}</td>
                                    <td>{{ $kanvasing->provinsi_name }}</td>
                                    <td>{{ $kanvasing->kabupaten_name }}</td>
                                    <td>{{ $kanvasing->kecamatan_name }}</td>
                                    <td>{{ $kanvasing->kelurahan_name }}</td>
                                    <td>{{ $kanvasing->nama_kk }}</td>
                                    <td>{{ $kanvasing->nomor_hp }}</td>
                                    <td>{{ $kanvasing->alamat }}</td>
                                    <td>{{ $kanvasing->elektabilitas == 1 ? 'Memilih' : ($kanvasing->elektabilitas == 2 ? 'Tidak Memilih' : 'Tidak Diketahui') }}</td>
                                    <td>{{ $kanvasing->popularitas == 1 ? 'Kenal' : ($kanvasing->popularitas == 2 ? 'Tidak Kenal' : 'Tidak Diketahui') }}</td>
                                    <td>{{ $kanvasing->jenis_kelamin == 1 ? 'Laki-laki' : ($kanvasing->jenis_kelamin == 2 ? 'Perempuan' : 'Tidak Diketahui') }}</td>
                                    <td>{{ $kanvasing->usia }}</td>
                                    <td>{{ $kanvasing->jum_pemilih }}</td>
                                    <td>{{ $kanvasing->alasan }}</td>
                                    <td>{{ $kanvasing->pesan }}</td>
                                    <td>{{ $kanvasing->deskripsi }}</td>
                                    <td>
                                        <img src="{{ asset($kanvasing->foto) }}" alt="Foto" style="width: 50px; height: auto;">
                                    </td>
                                    <td>{{ $kanvasing->lang }}</td>
                                    <td>{{ $kanvasing->lat }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{{ route('kanvasing.edit', $kanvasing->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('kanvasing.destroy', $kanvasing->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="20" class="text-center">Tidak ada data.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>



@endsection
