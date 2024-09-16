<div class="app-navbar-item ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
    <div class="cursor-pointer symbol symbol-35px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
        <div>{{ Auth::user()->name }}</div>
    </div>

    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
        <div class="separator my-2"></div>

        <div class="menu-item px-5">
            <a href="{{ route('profile.edit') }}" class="menu-link px-5">My Profile</a>
        </div>

        <div class="separator my-2"></div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <div class="menu-item px-5">
                <a href="{{ route('logout') }}" class="menu-link px-5" onclick="event.preventDefault(); this.closest('form').submit();">Sign Out</a>
            </div>
        </form>
    </div>
</div>
