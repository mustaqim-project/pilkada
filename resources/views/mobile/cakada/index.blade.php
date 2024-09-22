@extends('mobile.frontend.layout.master')

@section('content')
<div class="page-content" style="min-height:60vh!important">
    <div class="page-title page-title-small">
        <h2><a href="#" data-back-button><i class="fa fa-arrow-left"></i></a>Tables</h2>
        <a href="#" data-menu="menu-main" class="bg-fade-gray1-dark shadow-xl preload-img" data-src="images/avatars/5s.png"></a>
    </div>
    <div class="card header-card shape-rounded" data-card-height="150">
        <div class="card-overlay bg-highlight opacity-95"></div>
        <div class="card-overlay dark-mode-tint"></div>
        <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
    </div>


    <div class="card card-style">
        <p class="content">
            Classic tabs, these are not a special element but sometimes a very needed one to have. Styled to
            match the current highlight.
        </p>
    </div>

    <div class="card card-style">
        <div class="content mb-2">
            <h3>Highlight Table</h3>
            <p>
                Match the page color scheme.
            </p>
            <table class="table table-borderless text-center rounded-sm shadow-l" style="overflow: hidden;">
                <thead>
                    <tr>
                        <th scope="col" class="bg-highlight color-white">Brand</th>
                        <th scope="col" class="bg-highlight color-white">Device</th>
                        <th scope="col" class="bg-highlight color-white">OS</th>
                        <th scope="col" class="bg-highlight color-white">Works</th>
                        <th scope="col" class="bg-highlight color-white">Works</th>
                        <th scope="col" class="bg-highlight color-white">Works</th>
                        <th scope="col" class="bg-highlight color-white">Works</th>
                        <th scope="col" class="bg-highlight color-white">Works</th>
                        <th scope="col" class="bg-highlight color-white">Works</th>
                        <th scope="col" class="bg-highlight color-white">Works</th>
                        <th scope="col" class="bg-highlight color-white">Works</th>
                        <th scope="col" class="bg-highlight color-white">Works</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-highlight color-gray1-dark">
                        <th scope="row">Apple</th>
                        <td>iPhone</td>
                        <td>iOS</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                    </tr>
                    <tr class="bg-highlight color-gray1-dark">
                        <th scope="row">Android</th>
                        <td>Pixel</td>
                        <td>Android</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                    </tr>
                    <tr class="bg-highlight color-gray1-dark">
                        <th scope="row">Nope</th>
                        <td>Nope</td>
                        <td>nOS</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card card-style">
        <div class="content mb-2">
            <h3>Dark Table</h3>
            <p>
                Dark tables are always gorgeous.
            </p>
            <table class="table table-borderless text-center rounded-sm shadow-l" style="overflow: hidden;">
                <thead>
                    <tr>
                        <th scope="col" class="bg-dark2-dark border-dark1-dark color-white">Brand</th>
                        <th scope="col" class="bg-dark2-dark border-dark1-dark color-white">Device</th>
                        <th scope="col" class="bg-dark2-dark border-dark1-dark color-white">OS</th>
                        <th scope="col" class="bg-dark2-dark border-dark1-dark color-white">Works</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-dark1-light">
                        <th scope="row">Apple</th>
                        <td>iPhone</td>
                        <td>iOS</td>
                        <td>Yes</td>
                    </tr>
                    <tr class="bg-dark1-light">
                        <th scope="row">Android</th>
                        <td>Pixel</td>
                        <td>Android</td>
                        <td>Yes</td>
                    </tr>
                    <tr class="bg-dark1-light">
                        <th scope="row">Nope</th>
                        <td>Nope</td>
                        <td>nOS</td>
                        <td>Yees</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <div class="card card-style">
        <div class="content mb-2">
            <h3>Light Colorful Values</h3>
            <p>
                Light table with colorful values and FontAwesome Icons.
            </p>
            <table class="table table-borderless text-center rounded-sm shadow-l" style="overflow: hidden;">
                <thead>
                    <tr class="bg-gray1-dark">
                        <th scope="col" class="color-theme">Brand</th>
                        <th scope="col" class="color-theme">Device</th>
                        <th scope="col" class="color-theme">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">Apple</th>
                        <td class="color-green1-dark">$500</td>
                        <td><i class="fa fa-arrow-up rotate-45 color-green1-dark"></i></td>
                    </tr>
                    <tr>
                        <th scope="row">Android</th>
                        <td class="color-yellow1-dark">$400</td>
                        <td><i class="fa fa-arrow-right rotate-45 color-yellow1-dark"></i></td>
                    </tr>
                    <tr>
                        <th scope="row">Nope</th>
                        <td class="color-red2-dark">$300</td>
                        <td><i class="fa fa-arrow-right rotate-90 color-red2-dark"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- footer and footer card-->
    <div class="footer" data-menu-load="menu-footer.html"></div>
</div>
<!-- end of page content-->



<script>
    $(document).ready(function() {
        $.ajax({
            url: 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json',
            method: 'GET',
            success: function(data) {
                let provinsiDropdown = $('#provinsi');
                data.forEach(function(provinsi) {
                    provinsiDropdown.append('<option value="' + provinsi.id + '">' + provinsi.name + '</option>');
                });
            }
        });

        $('#provinsi').change(function() {
            let provinsiId = $(this).val();
            $('#kabupaten_kota').html('<option value="">Pilih Kabupaten/Kota</option>');
            if (provinsiId) {
                $.ajax({
                    url: `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinsiId}.json`,
                    method: 'GET',
                    success: function(data) {
                        data.forEach(function(kabupaten) {
                            $('#kabupaten_kota').append('<option value="' + kabupaten.id + '">' + kabupaten.name + '</option>');
                        });
                    }
                });
            }
        });

        $('.btn-edit').click(function() {
            let id = $(this).data('id');
            $.ajax({
                url: `/cakada/${id}/edit`,
                method: 'GET',
                success: function(data) {
                    $('#modalCakada').modal('show');
                    $('#cakada_id').val(data.id);
                    $('#provinsi').val(data.provinsi);
                    $('#tipe_cakada_id').val(data.tipe_cakada_id);
                    $('#nama_calon_kepala').val(data.nama_calon_kepala);
                    $('#nama_calon_wakil').val(data.nama_calon_wakil);
                    $('#formCakada').attr('action', `/cakada/${id}`);
                    $('#formCakada').append('<input type="hidden" name="_method" value="PUT">');

                    $('#provinsi').trigger('change');

                    setTimeout(function() {
                        $('#kabupaten_kota').val(data.kabupaten_kota);
                    }, 500);
                }
            });
        });
    });
</script>

@endsection
