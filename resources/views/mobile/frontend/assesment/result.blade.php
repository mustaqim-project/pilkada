@extends('mobile.frontend.layout.master')

@section('content')
    <div class="page-content" style="margin-top:50px;">
        <div class="page-title page-title-small">
            <h2><a href="/" data-back-button><i class="fa fa-arrow-left"></i></a> Hasil Assessment</h2>
        </div>

        <div class="card header-card shape-rounded" data-card-height="150">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
        </div>


        <div class="card card-style">
            <div class="content">
                <h1>Hasil Evaluasi</h1>

                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 10px; border: none;"><strong>Hasil:</strong></td>
                        <td style="padding: 10px; border: none;">{{ $result }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border: none;"><strong>BMI:</strong></td>
                        <td style="padding: 10px; border: none;">{{ number_format($bmi, 2) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border: none;"><strong>Kategori BMI:</strong></td>
                        <td style="padding: 10px; border: none;">
                            @php
                                $bmiCategory = '';
                                if ($bmi < 18.5) {
                                    $bmiCategory = 'Underweight';
                                } elseif ($bmi >= 18.5 && $bmi < 24.9) {
                                    $bmiCategory = 'Normal';
                                } elseif ($bmi >= 25 && $bmi < 29.9) {
                                    $bmiCategory = 'Overweight';
                                } else {
                                    $bmiCategory = 'Obese';
                                }
                            @endphp
                            {{ $bmiCategory }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border: none;"><strong>BB Sekarang:</strong></td>
                        <td style="padding: 10px; border: none;">{{ number_format($bb, 2) }} kg</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border: none;"><strong>BB Ideal:</strong></td>
                        <td style="padding: 10px; border: none;">{{ number_format($bbIdeal, 2) }} kg</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border: none;"><strong>Kebutuhan Kalori Harian tanpa aktivitas:</strong>
                        </td>
                        <td style="padding: 10px; border: none;">{{ number_format($bmrBase, 2) }} kcal/hari</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border: none;"><strong>Kebutuhan Kalori Harian dengan aktivitas:</strong>
                        </td>
                        <td style="padding: 10px; border: none;">{{ number_format($bmrCorrected, 2) }} kcal/hari</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border: none;"><strong>Total Kebutuhan Kalori:</strong></td>
                        <td style="padding: 10px; border: none;">{{ number_format($totalCaloriesRounded, 2) }} kcal/hari
                        </td>
                    </tr>
                </table>

                {{-- <h2>Saran Konsumsi Kalori</h2> --}}
                {{-- <ul>
                    @foreach ($recommendedCalories as $food)
                        <li>{{ $food->nama_makanan }} - {{ $food->kalori_per_gram }} kalori per gram</li>
                    @endforeach
                </ul> --}}
            </div>
        </div>



        <div class="card card-style">
            <div class="content text-center">
                <h2>Saran</h2>
            </div>
            <div class="divider divider-small mb-3 bg-highlight"></div>

            <div class="content">
                @if ($result == 'Mengalami BED')
                    <div class="d-flex mb-4 pb-3">
                        <div>
                            <h5 class="font-16 font-600">Kurangi Konsumsi Makanan Tinggi Kalori dan Gula</h5>
                            <p>
                                Fokus pada makanan dengan kandungan serat tinggi dan protein rendah kalori.
                            </p>
                        </div>
                    </div>
                    <div class="d-flex mb-4 pb-3">
                        <div>
                            <h5 class="font-16 font-600">Konsultasikan dengan Ahli Gizi</h5>
                            <p>
                                Dapatkan rencana makan yang lebih tepat dari profesional.
                            </p>
                        </div>
                    </div>
                @elseif ($result == 'Beresiko BED')
                    <div class="d-flex mb-4 pb-3">
                        <div>
                            <h5 class="font-16 font-600">Perhatikan Pola Makan</h5>
                            <p>
                                Cobalah untuk tidak makan berlebihan dan ikuti diet seimbang dengan porsi makan yang
                                teratur.
                            </p>
                        </div>
                    </div>
                    <div class="d-flex mb-4 pb-3">
                        <div>
                            <h5 class="font-16 font-600">Pertimbangkan Berbicara dengan Konselor</h5>
                            <p>
                                Jika diperlukan, cari dukungan profesional untuk membantu mengatasi risiko BED.
                            </p>
                        </div>
                    </div>
                @else
                    <div class="d-flex mb-4 pb-3">
                        <div>
                            <h5 class="font-16 font-600">Teruskan Pola Makan Sehat</h5>
                            <p>
                                Pastikan asupan kalori sesuai dengan kebutuhan tubuh dan jaga keseimbangan nutrisi.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if ($result == 'Mengalami BED')
            <div class="card card-style text-center">
                <div class="content pb-2">
                    <h1>
                        <i data-feather="heart" data-feather-line="1" data-feather-size="55" data-feather-color="red2-dark"
                            data-feather-bg="red2-fade-dark">
                        </i>
                    </h1>
                    <h3 class="font-700 mt-2">Dukungan Penuh</h3>
                    <p class="font-12 mt-n1 color-highlight mb-3">Kami Ada untuk Anda</p>
                    <p class="boxed-text-xl">
                        Dapatkan dukungan dan layanan kesehatan
                    </p>
                    <a href="#"
                        class="btn btn-center-xl btn-m text-uppercase font-900 bg-highlight rounded-sm shadow-l">Hubungi
                        Sekarang</a>
                </div>
            </div>
        @elseif ($result == 'Beresiko BED')
            <div class="content mt-0">
                <div class="row">
                    <div class="col-6">
                        <a href="#"
                            class="btn btn-full btn-m rounded-s text-uppercase font-900 shadow-xl bg-highlight">
                            Mulai<br>Pemulihan
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="#"
                            class="btn btn-full btn-border btn-m rounded-s text-uppercase font-900 shadow-xl border-highlight color-highlight">
                            Hubungi<br>Ahli
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Homepage Slider-->
            <div class="single-slider-boxed text-center owl-no-dots owl-carousel">
                <div class="card rounded-l shadow-l" data-card-height="320">
                    <div class="card-bottom">
                        <h1 class="font-24 font-700">
                            Kenali Binge Eating Disorder
                        </h1>
                        <p class="boxed-text-xl">
                            Pelajari tentang Binge Eating Disorder, bagaimana mengenali gejalanya, dan cara mengatasinya
                            dengan bijak.
                        </p>
                    </div>
                    <div class="card-overlay bg-gradient-fade"></div>
                    <div class="card-bg owl-lazy"
                        data-src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSY-kEcR4MozEQYAJ15m3FGY-t8c1tpJpqSdg&s">
                    </div>
                </div>
                <div class="card rounded-l shadow-l" data-card-height="320">
                    <div class="card-bottom">
                        <h1 class="font-24 font-700">
                            Kisah Pemulihan
                        </h1>
                        <p class="boxed-text-xl">
                            Baca cerita inspiratif dari mereka yang berhasil mengatasi Binge Eating Disorder dan menemukan
                            keseimbangan hidup.
                        </p>
                    </div>
                    <div class="card-overlay bg-gradient-fade"></div>
                    <div class="card-bg owl-lazy"
                        data-src="https://res.cloudinary.com/dk0z4ums3/image/upload/v1614664558/attached_image/beragam-manfaat-olahraga.jpg">
                    </div>
                </div>
                <div class="card rounded-l shadow-l" data-card-height="320">
                    <div class="card-bottom">
                        <h1 class="font-24 font-700">
                            Dukungan dan Bantuan
                        </h1>
                        <p class="boxed-text-xl">
                            Temukan sumber daya dan dukungan yang tersedia untuk membantu Anda atau orang yang Anda cintai.
                        </p>
                    </div>
                    <div class="card-overlay bg-gradient-fade"></div>
                    <div class="card-bg owl-lazy"
                        data-src="https://storage.googleapis.com/ekrutassets/blogs/images/000/004/856/original/Kenali_apa_saja_fungsi_FAQ_dan_tips_membuat_FAQ_yang_efektif.jpg">
                    </div>
                </div>
            </div>
        @endif



    </div>
    <!-- end of page content-->
@endsection
