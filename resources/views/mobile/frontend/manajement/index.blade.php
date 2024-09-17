@extends('mobile.frontend.layout.master')

@section('content')

<div class="page-content">
    <div class="page-title page-title-small">
        <h2><a href="{{ route('dashboard') }}" data-back-button><i class="fa fa-arrow-left"></i></a>Beranda</h2>
    </div>
    <div class="card header-card shape-rounded" data-card-height="150">
        <div class="card-overlay bg-highlight opacity-95"></div>
        <div class="card-overlay dark-mode-tint"></div>
    </div>

    <!-- Homepage Slider -->
    <div class="content text-center">
        <div class="card card-style ml-0 mr-0 bg-white">
            <div class="row mt-3 pt-1 mb-3">
                <div class="col-4 text-center">
                    <a href="#">
                        <i class="ml-3 mr-3" data-feather="shield" style="color: #28a745;"></i>
                        <h5 class="color-black font-13 font-500 line-height-s" style="font-size: 0.8125rem;">Manajemen Timses</h5>
                    </a>
                </div>
                <div class="col-4 text-center">
                    <a href="#">
                        <i class="ml-3 mr-3" data-feather="activity" style="color: #FFC733;"></i>
                        <h5 class="color-black font-13 font-500 line-height-s" style="font-size: 0.8125rem;">Manajemen Kanvasing</h5>
                    </a>
                </div>
            </div>
            <div class="row mt-3 pt-1 mb-3">
                <div class="col-4 text-center">
                    <a href="#">
                        <i class="ml-3 mr-3" data-feather="map-pin" style="color: #FF5733;"></i>
                        <h5 class="color-black font-13 font-500 line-height-s" style="font-size: 0.8125rem;">Jenis Pilkada</h5>
                    </a>
                </div>
                <div class="col-4 text-center">
                    <a href="#">
                        <i class="ml-3 mr-3" data-feather="bar-chart-2" style="color: #33B5FF;"></i>
                        <h5 class="color-black font-13 font-500 line-height-s" style="font-size: 0.8125rem;">Calon Kepala Daerah</h5>
                    </a>
                </div>
                <div class="col-4 text-center">
                    <a href="#">
                        <i class="ml-3 mr-3" data-feather="alert-triangle" style="color: #dc3545;"></i>
                        <h5 class="color-black font-13 font-500 line-height-s" style="font-size: 0.8125rem;">Akses User</h5>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
