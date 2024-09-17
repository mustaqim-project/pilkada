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
                        <i class="ml-3 mr-3" data-feather="user" style="color: #FF5733;"></i>
                        <h5 class="color-black font-13 font-500 line-height-s" style="font-size: 0.8125rem;">Kunjungan Warga</h5>
                    </a>
                </div>
                <div class="col-4 text-center">
                    <a href="#">
                        <i class="ml-3 mr-3" data-feather="pie-chart" style="color: #33B5FF;"></i>
                        <h5 class="color-black font-13 font-500 line-height-s" style="font-size: 0.8125rem;">
                            Analisis Suara</h5>
                    </a>
                </div>
                <div class="col-4 text-center">
                    <a href="manajemen-relawan.html">
                        <i class="ml-3 mr-3" data-feather="users" style="color: #FFC733;"></i>
                        <h5 class="color-black font-13 font-500 line-height-s" style="font-size: 0.8125rem;">
                            Manajemen Relawan</h5>
                    </a>
                </div>

            </div>
        </div>
    </div>


@endsection
