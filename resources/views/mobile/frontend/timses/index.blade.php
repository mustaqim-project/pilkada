@extends('mobile.frontend.layout.master')

@section('content')
<style>
    .table {
        background-color: #ffffff;
        /* White background for tables */
        border-radius: 8px;
        /* Rounded corners for tables */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        /* Subtle shadow for depth */
    }

    .table th {
        background-color: #03836d;
        /* Bootstrap primary color */
        color: white;
        /* White text for table header */
        text-align: center;
        /* Center align header text */
    }

    .table td {
        vertical-align: middle;
        /* Vertically align cell content */
    }

    .btn-link {
        color: #007bff;
        /* Bootstrap primary color for buttons */
        text-decoration: none;
        /* Remove underline */
    }

    .btn-link:hover {
        text-decoration: underline;
        /* Underline on hover for better UX */
    }

    .detail {
        display: none;
        /* Hide detail section by default */
    }

    .detail table {
        margin-top: 10px;
        /* Space above detail table */
    }

</style>


<div class="page-content">
    <div class="page-title page-title-small">
        <h2><a href="{{ route('dashboard') }}"><i class="fa fa-arrow-left"></i></a>Beranda</h2>
    </div>
    <div class="card header-card shape-rounded" data-card-height="210">
        <div class="card-overlay bg-highlight opacity-95"></div>
        <div class="card-overlay dark-mode-tint"></div>
        <div class="card-bg preload-img" data-src="admin/mobile/myhr/images/sikad.png"></div>
    </div>

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
                            <th>Nama User</th>
                            <th>Total</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataForView as $userName => $dates)
                        <tr>
                            <td style="text-align: center">{{ $loop->iteration }}</td>
                            <td>{{ $userName }}</td>
                            <td style="text-align: center">{{ $dates['total'] }}</td>
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
                                                        <td>{{ $kanvasing->elektabilitas == 1 ? 'Memilih' : ($kanvasing->elektabilitas == 2 ? 'Tidak Memilih' : 'Tidak Diketahui') }}</td>
                                                        <td>{{ $kanvasing->popularitas == 1 ? 'Kenal' : ($kanvasing->popularitas == 2 ? 'Tidak Kenal' : 'Tidak Diketahui') }}</td>
                                                        <td>{{ $kanvasing->jenis_kelamin == 1 ? 'Laki-laki' : ($kanvasing->jenis_kelamin == 2 ? 'Perempuan' : 'Tidak Diketahui') }}</td>
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

<script>
    document.querySelectorAll('.toggle-detail').forEach(button => {
        button.addEventListener('click', () => {
            const detailDiv = button.nextElementSibling;
            detailDiv.style.display = detailDiv.style.display === 'none' ? 'block' : 'none';
        });
    });

</script>

@endsection
