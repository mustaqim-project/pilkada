@extends('mobile.frontend.layout.master')

@section('content')
<div class="page-content" style="margin-top:50px;">
    <div class="page-title page-title-large">



    </div>
    <div class="card header-card shape-rounded" data-card-height="210">
        <div class="card-overlay bg-highlight opacity-95"></div>
        <div class="card-overlay dark-mode-tint"></div>
        <div class="card-bg preload-img" data-src="{{ asset('mobile/images/logobulat.png') }}"></div>
    </div>



        <div class="card card-style">
            <div class="content">
                <h3>Assessment</h3>
                <div class="instructions mt-2 mb-5">
                    <h4>Cara Pengisian Assessment</h4>
                    <ul>
                        <li><strong>Berat Badan:</strong> Masukkan berat badan Anda dalam satuan kilogram pada kolom yang telah disediakan. Isian ini wajib untuk melanjutkan ke pertanyaan berikutnya.</li>
                        <li><strong>Pertanyaan Pilihan Ganda:</strong> Anda akan diberikan beberapa pertanyaan terkait pola makan dan kebiasaan Anda selama tiga bulan terakhir. Jawablah setiap pertanyaan dengan memilih opsi yang paling sesuai dengan pengalaman Anda.</li>
                        <li><strong>Pertanyaan Lanjutan:</strong> Jika Anda menjawab "Iya" pada pertanyaan pertama, pertanyaan tambahan akan muncul secara otomatis. Pertanyaan-pertanyaan ini dirancang untuk menggali lebih dalam tentang kebiasaan makan Anda.</li>
                        <li><strong>Pemilihan Opsi:</strong> Untuk pertanyaan yang mengharuskan Anda memilih dari beberapa opsi (seperti "Sering", "Kadang-kadang", dll.), pilihlah jawaban yang paling menggambarkan situasi Anda selama tiga bulan terakhir.</li>
                        <li><strong>Kerahasiaan Jawaban:</strong> Semua jawaban Anda bersifat rahasia dan akan digunakan hanya untuk keperluan penilaian.</li>
                    </ul>
                    <p>Setelah memastikan semua pertanyaan telah dijawab, tekan tombol "Submit" untuk menyelesaikan asesmen.</p>
                </div>

                <form action="{{ route('daily_entries.store') }}" method="POST">
                    @csrf
                    <!-- Berat Badan -->
                    <div class="input-style input-style-2 has-icon input-required">
                        <i class="input-icon fa fa-user"></i>
                        <span class="color-highlight">Berat Badan(kg):</span>
                        <em>(required)</em>
                        <input class="form-control" type="number" placeholder="" name="weight" required>
                    </div>

                    <!-- Pertanyaan 1 -->
                    <div class="input-style input-style-2 input-required">
                        <label>1. Dalam tiga bulan terakhir, apakah Anda pernah mengalami makan dalam jumlah banyak
                            lebih dari porsi biasanya?</label>
                    </div>
                    <div class="row mb-4">
                        <div class="col-6">
                            <div class="fac fac-radio fac-blue"><span></span>
                                <input id="question_1_yes" type="radio" name="question_1" value="1" >
                                <label for="question_1_yes">Iya</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="fac fac-radio fac-blue"><span></span>
                                <input id="question_1_no" type="radio" name="question_1" value="0" checked>
                                <label for="question_1_no">Tidak</label>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Questions (Initially Hidden) -->
                    <div id="additional-questions" style="display: none;">
                        <!-- Pertanyaan 2 -->
                        <div class="input-style input-style-2 input-required">
                            <label>2. Apakah Anda sedang merasa tertekan atau stress ketika mengonsumsi makan
                                berlebih?</label>
                        </div>
                        <div class="row mb-4">
                            <div class="col-6">
                                <div class="fac fac-radio fac-blue"><span></span>
                                    <input id="question_2_yes" type="radio" name="question_2" value="1">
                                    <label for="question_2_yes">Iya</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="fac fac-radio fac-blue"><span></span>
                                    <input id="question_2_no" type="radio" name="question_2" value="0">
                                    <label for="question_2_no">Tidak</label>
                                </div>
                            </div>
                        </div>

                        <!-- Pertanyaan 3 -->
                        <div class="input-style input-style-2 input-required">
                            <label>3. Seberapa sering Anda merasa tidak memiliki kemampuan mengendalikan pola makan dalam
                                tiga bulan terakhir?</label>
                            <em><i class="fa fa-angle-down"></i></em>
                            <select class="form-control" name="question_3">
                                <option value="Tidak pernah atau jarang">Tidak pernah atau jarang</option>
                                <option value="Kadang-kadang">Kadang-kadang</option>
                                <option value="Sering">Sering</option>
                                <option value="Selalu">Selalu</option>
                            </select>
                        </div>

                        <!-- Pertanyaan 4 -->
                        <div class="input-style input-style-2 input-required">
                            <label>4. Seberapa sering Anda makan dalam jumlah besar dalam waktu singkat (misalnya dalam
                                waktu 2 jam) selama tiga bulan terakhir?</label>
                            <em><i class="fa fa-angle-down"></i></em>
                            <select class="form-control" name="question_4">
                                <option value="Tidak pernah atau jarang">Tidak pernah atau jarang</option>
                                <option value="Kadang-kadang">Kadang-kadang</option>
                                <option value="Sering">Sering</option>
                                <option value="Selalu">Selalu</option>
                            </select>
                        </div>

                        <!-- Pertanyaan 5 -->
                        <div class="input-style input-style-2 input-required">
                            <label>5. Seberapa sering Anda merasa bersalah atau malu setelah makan berlebihan?</label>
                            <em><i class="fa fa-angle-down"></i></em>
                            <select class="form-control" name="question_5">
                                <option value="Tidak pernah atau jarang">Tidak pernah atau jarang</option>
                                <option value="Kadang-kadang">Kadang-kadang</option>
                                <option value="Sering">Sering</option>
                                <option value="Selalu">Selalu</option>
                            </select>
                        </div>

                        <!-- Pertanyaan 6 -->
                        <div class="input-style input-style-2 input-required">
                            <label>6. Seberapa sering Anda makan sendirian karena merasa malu atau malu makan di depan orang
                                lain?</label>
                            <em><i class="fa fa-angle-down"></i></em>
                            <select class="form-control" name="question_6">
                                <option value="Tidak pernah atau jarang">Tidak pernah atau jarang</option>
                                <option value="Kadang-kadang">Kadang-kadang</option>
                                <option value="Sering">Sering</option>
                                <option value="Selalu">Selalu</option>
                            </select>
                        </div>

                        <!-- Pertanyaan 7 -->
                        <div class="input-style input-style-2 input-required">
                            <label>7. Seberapa sering Anda makan secara cepat selama tiga bulan terakhir?</label>
                            <em><i class="fa fa-angle-down"></i></em>
                            <select class="form-control" name="question_7">
                                <option value="Tidak pernah atau jarang">Tidak pernah atau jarang</option>
                                <option value="Kadang-kadang">Kadang-kadang</option>
                                <option value="Sering">Sering</option>
                                <option value="Selalu">Selalu</option>
                            </select>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="input-style input-style-2">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>
            </div>
        </div>




    </div>
    <script>
        document.querySelectorAll('input[name="question_1"]').forEach((element) => {
            element.addEventListener('change', (event) => {
                const additionalQuestions = document.getElementById('additional-questions');
                if (event.target.value === '1') {
                    additionalQuestions.style.display = 'block';
                } else {
                    additionalQuestions.style.display = 'none';
                }
            });
        });
    </script>
@endsection
