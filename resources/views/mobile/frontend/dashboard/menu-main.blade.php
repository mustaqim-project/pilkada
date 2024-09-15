<div class="menu-header">
    <a href="#" data-toggle-theme class="border-right-0">
        <i class="fa font-12 color-yellow1-dark fa-lightbulb"></i>
    </a>
    <a href="#" data-menu="menu-highlights" class="border-right-0">
        <i class="fa font-12 color-green1-dark fa-brush"></i>
    </a>
    <a href="#" data-menu="menu-share" class="border-right-0">
        <i class="fa font-12 color-red2-dark fa-share-alt"></i>
    </a>
    <a href="#" class="border-right-0">
        <i class="fa font-12 color-blue2-dark fa-cog"></i>
    </a>
    <a href="#" class="close-menu border-right-0">
        <i class="fa font-12 color-red2-dark fa-times"></i>
    </a>
</div>

<div class="menu-logo text-center">
    <a href="#"><img class="header-logo-app" width="100" src="{{ asset('mobile/images/logo.png') }}"></a>
    {{-- <p class="font-11 mt-n2" style="text-align: center;">Sistem Analisis Kampanye <br>dan <br>Analisis Pilkada Sitematis</p> --}}
</div>


<div class="menu-items">
    <h5 class="text-uppercase opacity-20 font-12 pl-3">
        Menu
    </h5>
    @if (Route::has('login'))
        <nav class="-mx-3 flex flex-1 justify-end">
            @auth
                <a href="{{ route('profile.edit') }}"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                    <i class="fa fa-user"></i>
                    <span>
                        Profile
                    </span>

                </a>


                <a href="#"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <!-- Logout Icon -->
                    <i class="fa fa-sign-out-alt"></i>
                    <span>
                        Log Out
                    </span>
                </a>

                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>
            @else
                <a href="#" data-menu="menu-signin">
                    <i class="fa fa-sign-in-alt color-green1-dark"></i>
                    <span>Login</span>
                    <i class="fa fa-angle-right"></i>
                </a>
                <a href="#" data-menu="menu-signup">
                    <i class="fa fa-sign-out-alt color-green1-dark"></i>
                    <span>Register</span>
                    <i class="fa fa-angle-right"></i>
                </a>


            @endauth
        </nav>
    @endif

    <div id="menu-signin" class="menu menu-box-bottom menu-box-detached rounded-m" data-menu-height="320"
        data-menu-effect="menu-over">
        <div class="content mb-0">
            <h1 class="font-700 mb-0">Login</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input-style has-icon input-style-1 input-required">
                    <i class="input-icon fa fa-user font-11"></i>
                    <span>Email</span>
                    <em>(required)</em>
                    <input type="email" placeholder="email">
                </div>
                <div class="input-style has-icon input-style-1 input-required">
                    <i class="input-icon fa fa-lock font-11"></i>
                    <span>Password</span>
                    <em>(required)</em>
                    <input type="password" placeholder="Password">
                </div>
                <div class="row">
                    <div class="col-6">
                        <a href="#" data-menu="menu-forgot" class="font-10">Forgot Password?</a>
                    </div>
                    <div class="col-6">
                        <a data-menu="menu-signup" href="#" class="float-right font-10">Create Account</a>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <a href="#"
                    class="btn btn-full btn-m shadow-l rounded-s text-uppercase font-900 bg-green1-dark mt-4">LOGIN</a>
            </form>
        </div>
    </div>

    <!---------------->
    <!---------------->
    <!--Menu Sign Up-->
    <!---------------->
    <!---------------->
    <div id="menu-signup" class="menu menu-box-bottom menu-box-detached rounded-m" data-menu-height="370"
        data-menu-effect="menu-over">
        <div class="content mb-0">
            <h1 class="font-700 mb-0">Register</h1>
            <p class="font-11  mt-n1 mb-0">
                Don't have an account? Register below.
            </p>
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf
                <div class="input-style has-icon input-style-1 input-required">
                    <i class="input-icon fa fa-user font-11"></i>
                    <span>Username</span>
                    <em>(required)</em>
                    <input type="name" placeholder="Username">
                </div>
                <div class="input-style has-icon input-style-1 input-required">
                    <i class="input-icon fa fa-at"></i>
                    <span>Email</span>
                    <em>(required)</em>
                    <input type="email" placeholder="Email">
                </div>
                <div class="input-style has-icon input-style-1 input-required">
                    <i class="input-icon fa fa-lock font-11"></i>
                    <span>Password</span>
                    <em>(required)</em>
                    <input type="password" placeholder="Choose a Password">
                </div>
                <div class="input-style has-icon input-style-1 input-required">
                    <i class="input-icon fa fa-lock font-11"></i>
                    <span>Confirm Password</span>
                    <em>(required)</em>
                    <input type="password_confirmation" placeholder="Choose a Password">
                </div>
                <p class="text-center pb-0 mb-n1 pt-1">
                    <a href="#" data-menu="menu-signin" class="text-center font-11 color-gray2-dark">Already
                        Registered? Sign In Here.</a>
                </p>
                <a href="#"
                    class="btn btn-full btn-m shadow-l rounded-s text-uppercase font-900 bg-blue2-dark mt-4">Register</a>
            </form>
        </div>
    </div>



</div>

<div class="text-center pt-2">
    <a href="#" class="icon icon-xs mr-1 rounded-s bg-facebook"><i class="fab fa-facebook"></i></a>
    <a href="#" class="icon icon-xs mr-1 rounded-s bg-twitter"><i class="fab fa-twitter"></i></a>
    <a href="#" class="icon icon-xs mr-1 rounded-s bg-instagram"><i class="fab fa-instagram"></i></a>
    <a href="#" class="icon icon-xs mr-1 rounded-s bg-linkedin"><i class="fab fa-linkedin-in"></i></a>
    <a href="#" class="icon icon-xs rounded-s bg-whatsapp"><i class="fab fa-whatsapp"></i></a>
    <p class="mb-0 pt-3 font-10 opacity-30">
        Hak Cipta <span class="copyright-year"></span> Enabled. Semua hak dilindungi.

    </p>
</div>
