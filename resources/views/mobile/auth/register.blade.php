@extends('mobile.frontend.layout.master')

@section('content')
<style>
    #image_preview {
        max-width: 100%; /* Atur lebar maksimal gambar */
        height: auto; /* Jaga agar proporsi gambar tetap */
        display: block; /* Tampilkan gambar secara blok */
        margin-top: 10px; /* Jarak atas */
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

                <!-- Username -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-user color-theme"></i>
                    <span>Username</span>
                    <x-text-input id="username" class="input" type="text" name="username" :value="old('username')" required
                        autofocus autocomplete="username" placeholder="Username" />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-at color-theme"></i>
                    <span>Email</span>
                    <x-text-input id="email" class="input" type="email" name="email" :value="old('email')"
                        required autocomplete="email" placeholder="Email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>



                <!-- Tanggal Lahir -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-calendar color-theme"></i>
                    <span>Tanggal Lahir</span>
                    <x-text-input id="tanggal_lahir" class="input" type="date" name="tanggal_lahir"
                        :value="old('tanggal_lahir')" required autocomplete="bday" />
                    <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                </div>

                <!-- Tinggi Badan -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-ruler-vertical color-theme"></i>
                    <span>Tinggi Badan (cm)</span>
                    <x-text-input id="tinggi_badan" class="input" type="number" name="tinggi_badan" :value="old('tinggi_badan')"
                        required autocomplete="height" placeholder="Tinggi Badan" step="any" />
                    <x-input-error :messages="$errors->get('tinggi_badan')" class="mt-2" />
                </div>

                <!-- Berat Badan -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-weight color-theme"></i>
                    <span>Berat Badan (kg)</span>
                    <x-text-input id="berat_badan" class="input" type="number" name="berat_badan" :value="old('berat_badan')"
                        required autocomplete="weight" placeholder="Berat Badan" step="any" />
                    <x-input-error :messages="$errors->get('berat_badan')" class="mt-2" />
                </div>

                <!-- Jenis Kelamin -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <span>Jenis Kelamin</span>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="input">
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                </div>

                <!-- Aktifitas -->
                <div class="input-style has-icon input-style-1 mt-4">
                    <span>Pilih Aktifitas</span>
                    <select id="aktifitas_id" name="aktifitas_id" class="input">
                        <option value="">Pilih Aktifitas</option>
                        @foreach ($aktifitas as $id => $nama)
                            <option value="{{ $id }}" {{ old('aktifitas_id') == $id ? 'selected' : '' }}>
                                {{ $nama }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('aktifitas_id')" class="mt-2" />
                </div>

                <!-- Profile Picture Upload -->
                    <div class="mt-4">
                        <img id="image_preview" src="#" alt="Image Preview"
                            style="display:none; width:200px; height:auto;" />
                    </div>
                    <div class="file-data">
                        <input type="file"  id="profile_picture" name="profile_picture" class="upload-file bg-highlight shadow-s rounded-s " accept="image/*">
                        <p class="upload-file-text color-white">Upload Image</p>
                        <x-input-error :messages="$errors->get('profile_picture')" class="mt-2" />
                    </div>

                <!-- Image Preview -->


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
                <button type="submit" class="btn btn-m btn-full rounded-sm shadow-l bg-green1-dark text-uppercase font-900">
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
