@extends('mobile.frontend.layout.master')

@section('content')
<div class="page-content">
    <div class="page-title page-title-small">
        <h2><a href="/" data-back-button><i class="fa fa-arrow-left"></i></a>Lupa Password</h2>
        {{-- <a href="#" data-menu="menu-main" class="bg-fade-gray1-dark shadow-xl preload-img" data-src="images/avatars/5s.png"></a> --}}
    </div>
    <div class="card header-card shape-rounded" data-card-height="150">
        <div class="card-overlay bg-highlight opacity-95"></div>
        <div class="card-overlay dark-mode-tint"></div>
        {{-- <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div> --}}
    </div>

    <!-- Session Status -->
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    <style>
        .btn-full {
            display: inline-block;
            width: 100%;
            padding: 0.75rem 1.5rem;
            /* Padding atas/bawah dan kiri/kanan */
            border: none;
            border-radius: 0.375rem;
            /* Radius sudut */
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
            /* Warna teks putih */
            background-color: #007bff;
            /* Ganti dengan warna latar belakang sesuai kebutuhan */
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-highlight {
            background-color: #28a745;
            /* Ganti dengan warna latar belakang highlight */
        }

        .btn-full:hover {
            background-color: #0056b3;
            /* Ganti dengan warna latar belakang saat hover */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Bayangan saat hover */
        }

        .btn-full:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.5);
            /* Bayangan fokus */
        }

    </style>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="card card-style">
            <div class="content mt-2 mb-0">
                <!-- Email Address -->
                <div class="input-style has-icon input-style-1 input-required pb-1">
                    <i class="input-icon fa fa-envelope color-theme"></i>
                    <span>Email</span>
                    <em>(required)</em>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Email">
                    @error('email')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>


                <!-- Login Button -->
                <button type="submit" class="btn btn-m mt-2 mb-4 btn-full bg-green1-dark rounded-sm text-uppercase font-900">Login</button>

            </div>
        </div>
    </form>

</div>
@endsection
