@extends('desktop.layouts.master')

@section('content')
<!--begin::Content wrapper-->
<div class="d-flex flex-column flex-column-fluid">
    <style>

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


    </style>
    {{-- BREADCRUMBS --}}
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    SIKADSIS
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Role Permission</li>
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

            <a href="{{ route('role.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Data
            </a>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>{{ __('Role Name') }}</th>
                                <th>{{ __('Permissions') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @foreach ($role->permissions as $permission)
                                            <span class="badge bg-primary text-light">{{ $permission->name }}</span>
                                        @endforeach
                                        @if ($role->name === 'Admin')
                                            <span class="badge bg-danger text-light">{{ __('All Permissions') }} *</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($role->name != 'Admin')
                                            <div class="btn-group" role="group" aria-label="Action buttons">
                                                <a href="{{ route('role.edit', $role->id) }}" class="btn btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('role.destroy', $role->id) }}" class="btn btn-danger delete-item">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        @endif
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
@endsection


@push('scripts')
    <script>

        $("#table").dataTable({
            "columnDefs": [{
                "sortable": false,
                "targets": [2, 3]
            }]
        });

    </script>
@endpush
