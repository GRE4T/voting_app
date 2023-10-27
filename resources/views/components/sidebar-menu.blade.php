<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('home')}}">
                    <img src="{{ asset('assets/images/icons/home.png') }}" alt="icon-home" class="w-40">
                    <span class="nav-text">Inicio</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->is('voting-booths') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('voting-booths.index')}}">
                    <img src="{{ asset('assets/images/icons/voting_booths.png') }}" alt="icon-agreement" class="w-40">
                    <span class="nav-text">Puestos de votación</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->is('parties') ? 'active' : '' }}" >
                <a class="nav-item-hold" href="{{route('parties.index')}}">
                    <img src="{{ asset('assets/images/icons/parties.png') }}" alt="icosn-headquarter" class="w-40">
                    <span class="nav-text">Partidos</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->is('records') ? 'active' : '' }}" >
                <a class="nav-item-hold" href="{{route('records.index')}}">
                    <img src="{{ asset('assets/images/icons/votes.png') }}" alt="icon-payment" class="w-40">
                    <span class="nav-text">Consolidado</span>
                </a>
                <div class="triangle"></div>
            </li>
            @if(auth()->user()->is_admin)
                <li class="nav-item {{ request()->is('users') ? 'active' : '' }}" >
                    <a class="nav-item-hold" href="{{route('users.index')}}">
                        <img src="{{ asset('assets/images/icons/user.png') }}" alt="icon-court" class="w-40">
                        <span class="nav-text">Usuarios</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endif
        </ul>
    </div>
    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================-->
