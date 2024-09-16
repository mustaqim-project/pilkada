@extends('mobile.frontend.layout.master')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


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




    .container {
        margin-top: 20px;
    }

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
<div class="page-content">
    <div class="page-title page-title-small">
        <h2><a href="/" data-back-button><i class="fa fa-arrow-left"></i></a>Beranda</h2>
    </div>
    <div class="card header-card shape-rounded" data-card-height="150">
        <div class="card-overlay bg-highlight opacity-95"></div>
        <div class="card-overlay dark-mode-tint"></div>
    </div>

    <form method="POST" action="{{ route('kanvasing.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="card card-style">
            <div class="content mb-0 mt-1">
                <!-- user id -->
                <Label>Tim Lapangan</Label>
                @if (Route::has('login'))
                <div class="input-style has-icon input-style-1 input-required">
                    <select name="user_id" id="user_id" class="input" required>
                        <option id="user_id" name="user_id" value="{{ Auth::user()->id }}">
                            {{ Auth::user()->name }}</option>
                    </select>
                    <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                </div>
                @endif

                <!-- Provinsi -->
                <div class="input-style has-icon input-style-1 input-required">
                    <span>Provinsi</span>
                    <select name="provinsi" id="provinsi" class="input" required>
                        <option value="">Pilih Provinsi</option>
                        @foreach ($provinsi as $prov)
                        <option value="{{ $prov['id'] }}">{{ $prov['name'] }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('provinsi')" class="mt-2" />
                </div>

                <!-- Kabupaten/Kota -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <span>Kabupaten/Kota</span>
                    <select name="kabupaten_kota" id="kabupaten_kota" class="input" required>
                        <option value="">Pilih Kabupaten/Kota</option>
                        <!-- Options will be populated by JavaScript -->
                    </select>
                    <x-input-error :messages="$errors->get('kabupaten_kota')" class="mt-2" />
                </div>

                <!-- Kecamatan -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <span>Kecamatan</span>
                    <select name="kecamatan" id="kecamatan" class="input" required>
                        <option value="">Pilih Kecamatan</option>
                    </select>
                    <x-input-error :messages="$errors->get('kecamatan')" class="mt-2" />
                </div>

                <!-- Kelurahan -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <span>Kelurahan</span>
                    <select name="kelurahan" id="kelurahan" class="input" required>
                        <option value="">Pilih Kelurahan</option>
                    </select>
                    <x-input-error :messages="$errors->get('kelurahan')" class="mt-2" />
                </div>

                <!-- RW -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-ruler color-theme"></i>
                    <span>RW</span>
                    <x-text-input id="rw" class="input" type="text" name="rw" :value="old('rw')" required placeholder="RW" />
                    <x-input-error :messages="$errors->get('rw')" class="mt-2" />
                </div>

                <!-- RT -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-ruler color-theme"></i>
                    <span>RT</span>
                    <x-text-input id="rt" class="input" type="text" name="rt" :value="old('rt')" required placeholder="RT" />
                    <x-input-error :messages="$errors->get('rt')" class="mt-2" />
                </div>

                <!-- Tipe Cakada ID -->
                <label class="mt-4">Pilkada</label>
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <select id="tipe_cakada_id" name="tipe_cakada_id" class="input" required>
                        <option value="" disabled selected>Pilih Tipe Pilkada</option>
                        @foreach ($tipe_cakada as $item)
                        <option value="{{ $item->id }}" {{ old('tipe_cakada_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('tipe_cakada_id')" class="mt-2" />
                </div>

                <!-- Cakada ID -->
                <label class="mt-4">Nama Kandidat</label>
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <select id="cakada_id" name="cakada_id" class="input" required>
                        <option value="">Pilih Nama Kandidat</option>
                        <!-- Options will be populated by JavaScript -->
                    </select>
                    <x-input-error :messages="$errors->get('cakada_id')" class="mt-2" />
                </div>
                <!-- Nama KK -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-user color-theme"></i>
                    <span>Nama KK</span>
                    <x-text-input id="nama_kk" class="input" type="text" name="nama_kk" :value="old('nama_kk')" required placeholder="Nama KK" />
                    <x-input-error :messages="$errors->get('nama_kk')" class="mt-2" />
                </div>

                <!-- Nomor HP -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-phone color-theme"></i>
                    <span>Nomor HP</span>
                    <x-text-input id="nomor_hp" class="input" type="text" name="nomor_hp" :value="old('nomor_hp')" required placeholder="Nomor HP" />
                    <x-input-error :messages="$errors->get('nomor_hp')" class="mt-2" />
                </div>

                <!-- Jumlah Pemilih -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-users color-theme"></i>
                    <span>Jumlah Pemilih</span>
                    <x-text-input id="jum_pemilih" class="input" type="number" name="jum_pemilih" :value="old('jum_pemilih')" required placeholder="Jumlah Pemilih" />
                    <x-input-error :messages="$errors->get('jum_pemilih')" class="mt-2" />
                </div>

                <!-- Alamat -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-address-card color-theme"></i>
                    <span>Alamat</span>
                    <x-text-input id="alamat" class="input" type="text" name="alamat" :value="old('alamat')" required placeholder="Alamat" />
                    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                </div>



                <!-- Popularitas -->
                <label class="mt-4">Apakah kenal dengan calon ?</label>
                <div class="input-style has-icon input-style-1 input-required mt-2">
                    <select id="popularitas" name="popularitas" class="input" required>
                        <option value="">Pilih</option>
                        <option value="1" {{ old('popularitas') == '1' ? 'selected' : '' }}>Ya</option>
                        <option value="2" {{ old('popularitas') == '2' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <x-input-error :messages="$errors->get('popularitas')" class="mt-2" />
                </div>

                <!-- Elektabilitas -->
                <label class="mt-4">Apakah anda akan memilih calon tersebut?</label>
                <div class="input-style has-icon input-style-1 input-required mt-2">
                    <select id="elektabilitas" name="elektabilitas" class="input" required>
                        <option value="">Pilih</option>
                        <option value="1" {{ old('elektabilitas') == '1' ? 'selected' : '' }}>Ya</option>
                        <option value="2" {{ old('elektabilitas') == '2' ? 'selected' : '' }}>Tidak</option>
                        <option value="3" {{ old('elektabilitas') == '3' ? 'selected' : '' }}>Ragu-ragu</option>
                    </select>
                    <x-input-error :messages="$errors->get('elektabilitas')" class="mt-2" />
                </div>
                <!-- Alasan -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-address-card color-theme"></i>
                    <span>Alasan memilih calon tersebut ?</span>
                    <x-text-input id="alasan" class="input" type="text" name="alasan" :value="old('alasan')" required placeholder="alasan memilih kandidat" />
                    <x-input-error :messages="$errors->get('alasan')" class="mt-2" />
                </div>
                <!-- pesan -->
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-address-card color-theme"></i>
                    <span>Pesan untuk calon kepala daerah jika terpilih?</span>
                    <x-text-input id="pesan" class="input" type="text" name="pesan" :value="old('pesan')" required placeholder="pesan untuk kandidat" />
                    <x-input-error :messages="$errors->get('pesan')" class="mt-2" />
                </div>

                <!-- Stiker -->
                <label class="mt-4">Apakah boleh memasang atribut kampanye berupa stiker/pamflet/brosur dll?</label>
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <select id="stiker" name="stiker" class="input" required>
                        <option value="">Pilih</option>
                        <option value="1" {{ old('stiker') == '1' ? 'selected' : '' }}>Ya</option>
                        <option value="2" {{ old('stiker') == '2' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <x-input-error :messages="$errors->get('stiker')" class="mt-2" />
                </div>



                <!-- Upload Foto -->
                <div class="mt-4">
                    <img id="image_preview" src="#" alt="Image Preview" style="display:none;" />
                </div>
                <div class="file-data">
                    <input type="file" id="foto" name="foto" class="upload-file bg-highlight shadow-s rounded-s" accept="image/*">
                    <p class="upload-file-text color-white">Upload Foto Kegiatan</p>
                    <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                </div>
                <!-- deskripsi -->
                <label class="mt-5">Kendala dilapangan jika ada!</label>
                <div class="input-style has-icon input-style-1 input-required mt-4">
                    <i class="input-icon fa fa-address-card color-theme"></i>
                    <x-text-input id="deskripsi" class="input" type="text" name="deskripsi" :value="old('deskripsi')" required placeholder="Kendala dilapangan jika ada!" />
                    <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                </div>
                <!-- Lokasi Saya -->
                <div class="input-style has-icon input-style-1 mt-4">
                    <i class="input-icon fa fa-map-pin color-theme"></i>
                    <span>Lokasi Saya</span>
                    <x-text-input id="location_name" class="input" type="text" name="location_name" readonly :value="old('location_name')" placeholder="Lokasi Saya" />
                    <x-input-error :messages="$errors->get('location_name')" class="mt-2" />
                </div>
                <!-- Lokasi Saya -->
                <div class="input-style has-icon input-style-1 mt-4">
                    <span>Longitude</span>
                    <x-text-input id="lang" class="input" type="text" name="lang" readonly :value="old('lang')" />
                    <x-input-error :messages="$errors->get('lang')" class="mt-2" />
                </div>
                <div class="input-style has-icon input-style-1 mt-4">
                    <span>Latitude</span>
                    <x-text-input id="lat" class="input" type="text" name="lat" readonly :value="old('lat')" />
                    <x-input-error :messages="$errors->get('lat')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="card card-style">
            <div class="content">
                <h3 class="font-700">Get Coordinates</h3>
                <a href="#" class="get-location btn btn-full btn-m bg-red2-dark rounded-sm text-uppercase shadow-l font-900">Get
                    my Location</a>
                <p class="location-coordinates"></p>

            </div>
            <div class="responsive-iframe add-iframe">
                <iframe class="location-map" src='https://maps.google.com/?ie=UTF8&amp;ll=47.595131,-122.330414&amp;spn=0.006186,0.016512&amp;t=h&amp;z=17&amp;output=embed'></iframe>
            </div>
        </div>

        <button type="submit" class="btn btn-full btn-highlight">Simpan</button>
    </form>

    <div id="map" style="display: none;"></div>

</div>


@endsection
