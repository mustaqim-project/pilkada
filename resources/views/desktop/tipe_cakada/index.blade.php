@extends('desktop.layouts.master')

@section('content')
<!--begin::Content wrapper-->
<div class="d-flex flex-column flex-column-fluid">

    {{-- BREADCUM --}}
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Dashboard</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Tipe Pilkada</li>
                </ul>
            </div>
        </div>
    </div>

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">

            <div class="container mt-5">
                <h1>Daftar Tipe Cakada</h1>

                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Button to open the modal -->
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tipeCakadaModal">
                    Tambah Tipe Cakada
                </button>

                <!-- Modal Tambah/Edit Tipe Cakada -->
                <div class="modal fade" id="tipeCakadaModal" tabindex="-1" aria-labelledby="tipeCakadaModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tipeCakadaModalLabel">Tambah / Edit Tipe Cakada</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @if(isset($editTipeCakada))
                                <form action="{{ route('tipe_cakada.update', $editTipeCakada->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    @else
                                    <form action="{{ route('tipe_cakada.store') }}" method="POST">
                                        @csrf
                                        @endif
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nama Tipe Cakada</label>
                                            <input type="text" name="name" class="form-control" id="name" value="{{ isset($editTipeCakada) ? $editTipeCakada->name : '' }}" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">{{ isset($editTipeCakada) ? 'Update' : 'Tambah' }}</button>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Daftar Tipe Cakada -->
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Tipe</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tipeCakada as $tipe)
                        <tr>
                            <td>{{ $tipe->id }}</td>
                            <td>{{ $tipe->name }}</td>
                            <td>
                                <!-- Button to open edit modal -->
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#tipeCakadaModal" onclick="editTipeCakada({{ $tipe->id }}, '{{ $tipe->name }}')">
                                    Edit
                                </button>

                                <!-- Form Hapus -->
                                <form action="{{ route('tipe_cakada.destroy', $tipe->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

</div>
<!--end::Content wrapper-->

@section('scripts')
<script>
    function editTipeCakada(id, name) {
        var form = document.querySelector('#tipeCakadaModal form');
        form.action = '{{ route('tipe_cakada.update', '') }}/' + id;
        document.querySelector('#tipeCakadaModalLabel').textContent = 'Edit Tipe Cakada';
        document.querySelector('#name').value = name;
        form.querySelector('button[type="submit"]').textContent = 'Update';
    }
</script>
@endsection

@endsection
