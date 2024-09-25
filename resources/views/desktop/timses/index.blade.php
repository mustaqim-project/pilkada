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
                        <table>
                            <thead>
                                <tr>
                                    <th>Nama User</th>
                                    <th>Total Kanvasing</th>
                                    <th>Detail Kanvasing</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userKanvasingCounts as $userId => $userData)
                                <tr>
                                    <td>{{ $userData['name'] }}</td>
                                    <td>{{ $userData['total'] }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($userData['kanvasings'] as $kanvasing)
                                            <li>
                                                {{ $kanvasing->provinsi_name }},
                                                {{ $kanvasing->kabupaten_name }},
                                                {{ $kanvasing->kecamatan_name }},
                                                {{ $kanvasing->kelurahan_name }} -
                                                Cakada: {{ $kanvasing->cakada_kelapa }} ({{ $kanvasing->cakada_wakil }})
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



@endsection
