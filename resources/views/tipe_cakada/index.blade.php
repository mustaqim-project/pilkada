<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tipe Cakada</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Daftar Tipe Cakada</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Tambah/Edit Tipe Cakada -->
        <div class="card mb-5">
            <div class="card-header">
                Tambah / Edit Tipe Cakada
            </div>
            <div class="card-body">
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
                            <input type="text" name="name" class="form-control" id="name" value="{{ isset($editTipeCakada) ? $editTipeCakada->name : '' }}">
                        </div>
                        <button type="submit" class="btn btn-primary">{{ isset($editTipeCakada) ? 'Update' : 'Tambah' }}</button>
                    </form>
            </div>
        </div>

        <!-- Tabel Daftar Tipe Cakada -->
        <table class="table table-bordered">
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
                        <!-- Form Edit -->
                        <form action="{{ route('tipe_cakada.index') }}" method="GET" style="display:inline-block;">
                            <button type="submit" class="btn btn-warning btn-sm">Edit</button>
                        </form>

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
</body>
</html>
