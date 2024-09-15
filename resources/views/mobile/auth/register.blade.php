@extends('mobile.frontend.layout.master')

@section('content')
    <style>
        #image_preview {
            max-width: 100%;
            /* Atur lebar maksimal gambar */
            height: auto;
            /* Jaga agar proporsi gambar tetap */
            display: block;
            /* Tampilkan gambar secara blok */
            margin-top: 10px;
            /* Jarak atas */
        }
    </style>
    <div class="page-content">
        <div class="page-title page-title-small">
            <h2><a href="#" data-back-button><i class="fa fa-arrow-left"></i></a>Sign Up</h2>
            {{-- <a href="#" data-menu="menu-main" class="bg-fade-gray1-dark shadow-xl preload-img"
        data-src="{{ asset('mobile/images/logobulat.png') }}"> --}}
            </a>
        </div>
        <div class="card header-card shape-rounded" data-card-height="150">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
        </div>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <div class="card card-style">
                <div class="content mb-0 mt-1">
                    <!-- Name -->
                    <div class="input-style has-icon input-style-1 input-required">
                        <i class="input-icon fa fa-user color-theme"></i>
                        <span>Name</span>
                        <x-text-input id="name" class="input" type="text" name="name" :value="old('name')" required
                            autofocus autocomplete="name" placeholder="Name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>


                    <!-- Email Address -->
                    <div class="input-style has-icon input-style-1 input-required mt-4">
                        <i class="input-icon fa fa-at color-theme"></i>
                        <span>Email</span>
                        <x-text-input id="email" class="input" type="email" name="email" :value="old('email')" required
                            autocomplete="email" placeholder="Email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>


                    <!-- Password -->
                    <div class="input-style has-icon input-style-1 input-required mt-4">
                        <i class="input-icon fa fa-lock color-theme"></i>
                        <span>Password</span>
                        <x-text-input id="password" class="input" type="password" name="password" required
                            autocomplete="new-password" placeholder="Choose a Password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="input-style has-icon input-style-1 input-required mb-4">
                        <i class="input-icon fa fa-lock color-theme"></i>
                        <span>Confirm Password</span>
                        <x-text-input id="password_confirmation" class="input" type="password" name="password_confirmation"
                            required autocomplete="new-password" placeholder="Confirm your Password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="btn btn-m btn-full rounded-sm shadow-l bg-green1-dark text-uppercase font-900">
                        Create Account
                    </button>

                    <!-- Divider -->
                    <div class="divider"></div>

                    <!-- Sign-in Link -->
                    <p class="text-center">
                        <a href="{{ route('login') }}" class="color-highlight opacity-80 font-12">Already Registered? Sign
                            in
                            Here</a>
                    </p>

                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {


            // Handle image preview
            const profilePictureInput = document.getElementById('profile_picture');
            const imagePreview = document.getElementById('image_preview');

            profilePictureInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.src = '#';
                    imagePreview.style.display = 'none';
                }
            });
        });
    </script>
@endsection
