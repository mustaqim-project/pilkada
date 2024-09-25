@extends('desktop.layouts.master')

@section('content')
<style>
    body {
        background-color: #f8f9fa; /* Light background for better contrast */
    }

    .card {
        border: 1px solid #e0e0e0; /* Soft border for cards */
        border-radius: 8px; /* Rounded corners */
    }

    .table {
        background-color: #ffffff; /* White background for tables */
        border-radius: 8px; /* Rounded corners for tables */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    }

    .table th {
        background-color: #007bff; /* Bootstrap primary color */
        color: white; /* White text for table header */
        text-align: center; /* Center align header text */
    }

    .table td {
        vertical-align: middle; /* Vertically align cell content */
    }

    .btn-link {
        color: #007bff; /* Bootstrap primary color for buttons */
        text-decoration: none; /* Remove underline */
    }

    .btn-link:hover {
        text-decoration: underline; /* Underline on hover for better UX */
    }

    .detail {
        display: none; /* Hide detail section by default */
    }

    .detail table {
        margin-top: 10px; /* Space above detail table */
    }

    .breadcrumb {
        background: none; /* Remove background for breadcrumbs */
        padding: 0; /* Remove padding */
        margin: 0; /* Remove margin */
    }

    .page-heading {
        font-size: 1.5rem; /* Adjust page heading size */
        margin-bottom: 1rem; /* Space below heading */
    }
</style>


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
                    <li class="breadcrumb-item text-muted"> Kanvasing Timses </li>
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
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    timer: 2000,
                    showConfirmButton: false
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
                                    <th>Nama User</th>
                                    <th>Total Kanvasing Keseluruhan</th>
                                    <th>Tanggal</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataForView as $userName => $dates)
                                    <tr>
                                        <td>{{ $userName }}</td>
                                        <td>{{ $dates['total'] }}</td>
                                        <td>
                                            <ul>
                                                @foreach ($dates['dates'] as $date => $data)
                                                    <li>
                                                        {{ $date }} ({{ $data['total'] }})
                                                        <button class="toggle-detail btn btn-link">Lihat Detail</button>
                                                        <div class="detail">
                                                            <table class="table table-bordered mt-2">
                                                                <thead>
                                                                    <tr>
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
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($data['kanvasings'] as $kanvasing)
                                                                        <tr>
                                                                            <td>{{ $kanvasing->provinsi_name }}</td>
                                                                            <td>{{ $kanvasing->kabupaten_name }}</td>
                                                                            <td>{{ $kanvasing->kecamatan_name }}</td>
                                                                            <td>{{ $kanvasing->kelurahan_name }}</td>
                                                                            <td>{{ $kanvasing->nama_kk ?? 'Tidak Diketahui' }}</td>
                                                                            <td>{{ $kanvasing->nomor_hp ?? 'Tidak Diketahui' }}</td>
                                                                            <td>{{ $kanvasing->alamat ?? 'Tidak Diketahui' }}</td>
                                                                            <td>{{ $kanvasing->elektabilitas ?? 'Tidak Diketahui' }}</td>
                                                                            <td>{{ $kanvasing->popularitas ?? 'Tidak Diketahui' }}</td>
                                                                            <td>{{ $kanvasing->jenis_kelamin ?? 'Tidak Diketahui' }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.toggle-detail').forEach(button => {
        button.addEventListener('click', () => {
            const detailDiv = button.nextElementSibling;
            detailDiv.style.display = detailDiv.style.display === 'none' ? 'block' : 'none';
        });
    });
</script>

@endsection
