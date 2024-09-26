<!--begin::sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    @include('desktop.home-component.logo')
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
            <!--begin::Menu-->
            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                <!--begin:Menu item-->
                <div class="menu-item pt-5">
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">Menu</span>
                    </div>
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 4H15V6H9V4ZM21 4H17V6H21V4ZM21 10H17V12H21V10ZM15 10H9V12H15V10ZM15 16H9V18H15V16ZM21 16H17V18H21V16Z" fill="currentColor" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Management Pilkada</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('tipe_cakada.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Tipe Pilkada</span>
                            </a>
                        </div>
                        <!--end:Menu item-->

                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('cakada.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Daftar Calon Kepala Daerah</span>
                            </a>
                        </div>
                        <!--end:Menu item-->
                    </div>
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 4H15V6H9V4ZM21 4H17V6H21V4ZM21 10H17V12H21V10ZM15 10H9V12H15V10ZM15 16H9V18H15V16ZM21 16H17V18H21V16Z" fill="currentColor" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Manajemen Data Kandidat</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Profil Kandidat</span>
                            </a>
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Rekam Jejak Kandidat</span>
                            </a>
                        </div>
                        <!--end:Menu item-->
                    </div>
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 4H15V6H9V4ZM21 4H17V6H21V4ZM21 10H17V12H21V10ZM15 10H9V12H15V10ZM15 16H9V18H15V16ZM21 16H17V18H21V16Z" fill="currentColor" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Manajemen Kampanye</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Jadwal Kampanye</span>
                            </a>
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Peta Wilayah Kampanye</span>
                            </a>
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Manajemen Relawan</span>
                            </a>
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Laporan Aktivitas Kampanye</span>
                            </a>
                        </div>
                        <!--end:Menu item-->
                    </div>
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 4H15V6H9V4ZM21 4H17V6H21V4ZM21 10H17V12H21V10ZM15 10H9V12H15V10ZM15 16H9V18H15V16ZM21 16H17V18H21V16Z" fill="currentColor" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Analisis Pemilih dan Demografi</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Data Pemilih</span>
                            </a>
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Analisis Suara</span>
                            </a>
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Analisis SWOT</span>
                            </a>
                        </div>
                        <!--end:Menu item-->
                    </div>
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 4H15V6H9V4ZM21 4H17V6H21V4ZM21 10H17V12H21V10ZM15 10H9V12H15V10ZM15 16H9V18H15V16ZM21 16H17V18H21V16Z" fill="currentColor" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Laporan Keuangan</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Laporan Donasi</span>
                            </a>
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Pengeluaran Kampanye</span>
                            </a>
                        </div>
                        <!--end:Menu item-->
                    </div>
                </div>
                <!--end:Menu item-->


                <!-- Manajemen Saksi dan Tim Pemantau -->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 4H15V6H9V4ZM21 4H17V6H21V4ZM21 10H17V12H21V10ZM15 10H9V12H15V10ZM15 16H9V18H15V16ZM21 16H17V18H21V16Z" fill="currentColor" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Manajemen Saksi dan Tim Pemantau</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Registrasi Saksi</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Laporan Pemantauan TPS</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sistem Hasil Pilkada -->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 4H15V6H9V4ZM21 4H17V6H21V4ZM21 10H17V12H21V10ZM15 10H9V12H15V10ZM15 16H9V18H15V16ZM21 16H17V18H21V16Z" fill="currentColor" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Sistem Hasil Pilkada</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Hasil Quick Count</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Hasil Resmi KPU</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 4H15V6H9V4ZM21 4H17V6H21V4ZM21 10H17V12H21V10ZM15 10H9V12H15V10ZM15 16H9V18H15V16ZM21 16H17V18H21V16Z" fill="currentColor" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Role Akses</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('role-users.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">{{ __('Role Users') }}</span>
                            </a>
                        </div>
                        <!--end:Menu item-->

                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('role.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">{{ __('Roles and Permissions') }}</span>
                            </a>
                        </div>
                        <!--end:Menu item-->

                        <!--end:Menu item-->
                    </div>
                </div>
                <!--end:Menu item-->
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->

</div>
<!--end::sidebar-->
