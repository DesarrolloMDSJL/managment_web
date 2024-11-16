<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow"
style="background-image: url('../images/banner.jpg');opacity: 1 !important;"
data-scroll-to-active="true"
 >
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <div class="brand-logo"></div>
                    <h4 class="brand-text mb-0" style="color: #ffa249;
                    font-size: 1.4rem;">CENTRO COSTOS</h4>
                </a>
            </li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                    {{-- <i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i>
                    <i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block primary collapse-toggle-icon"
                        data-ticon="icon-disc">
                    </i> --}}
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div> 
    <div class="main-menu-content">
        <h6 class="text-center text-white" >ANALISIS DE INGRESO POR CENTRO DE COSTO</h6>
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @if(session('rolUserData')[0]->descripcion_corta == 'R22')
                <li class="nav-item {{ Route::currentRouteName() === 'dashboard' ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="feather icon-home"></i>
                        <span class="menu-title">RESUMEN AREAS</span>
                    </a>
                </li>
                <li class="nav-item mt-1 {{ Route::currentRouteName() === 'income' ? 'active' : '' }}">
                    <a href="{{ route('income') }}">
                        <i class="feather icon-home" style="height: 23px;"></i>
                        <span class="menu-title" style="text-wrap: wrap;">RESUMEN DE INGRESOS</span>
                    </a>
                </li>
                <li class="nav-item has-sub mt-1 {{ Route::currentRouteName() === 'report' 
                                                    || Route::currentRouteName() === 'fines' 
                                                    || Route::currentRouteName() === 'taxes'
                                                    || Route::currentRouteName() === 'departure' ? 'active' : '' }}">
                    <a href="#">
                        <i class="feather icon-circle"></i>
                        <span class="menu-title">REPORTE</span>
                    </a>
                    <ul class="menu-content" style="">
                        <li class="is-shown {{ Route::currentRouteName() === 'report' ? 'active' : '' }}">
                            <a href="{{ route('report') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-title">TUPA/TUSNE</span>
                            </a>
                        </li>
                        <li class="is-shown {{ Route::currentRouteName() === 'fines' ? 'active' : '' }}">
                            <a href="{{ route('fines') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-title">MULTAS</span>
                            </a>
                        </li>
                        <li class="is-shown {{ Route::currentRouteName() === 'taxes' ? 'active' : '' }}">
                            <a href="{{ route('taxes') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-title">TRIBUTARIA</span>
                            </a>
                        </li>
                        <li class="is-shown {{ Route::currentRouteName() === 'departure' ? 'active' : '' }}">
                            <a href="{{ route('departure') }}">
                                <i class="feather icon-circle" style="height: 23px !important;"></i>
                                <span class="menu-title" style="text-wrap: wrap;font-family: system-ui;">INGRESO POR FECHA</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if(session('rolUserData')[0]->descripcion_corta == 'R23')
                <li class="nav-item has-sub mt-1 {{ Route::currentRouteName() === 'report' ? 'active' : '' }}">
                    <a href="#">
                        <i class="feather icon-circle"></i>
                        <span class="menu-title">REPORTE</span>
                    </a>
                    <ul class="menu-content" style="">
                        <li class="is-shown {{ Route::currentRouteName() === 'report' ? 'active' : '' }}">
                            <a href="{{ route('report') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-title">TUPA/TUSNE</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
        {{-- <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li>prueba</li>
            @if (isset($menus))
                @foreach ($menus as $menu)
                    @if (isset($menu->navheader))
            <li class="navigation-header">
                <span>{{ $menu->navheader }}</span>
            </li>
                    @else
                        @php
                            $custom_classes = "";
                            if(isset($menu->classlist)) {
                                $custom_classes = $menu->classlist;
                            }
                            $translation = "";
                            if(isset($menu->i18n)){
                                $translation = $menu->i18n;
                            }
                        @endphp
                    <li class="nav-item {{ (request()->route()->getName() == $menu->name_url) ? 'active' : '' }} {{ $custom_classes }}">
                        <a href="{{ $menu->url }}">
                            <i class="{{ $menu->icon }}"></i>
                            <span class="menu-title">{{ $menu->name }}</span>
                            @if (isset($menu->badge))
                                <?php $badgeClasses = 'badge badge-pill badge-primary float-right'; ?>
                                <span class="{{ isset($menu->badgeClass) ? $menu->badgeClass.' test' : $badgeClasses.' notTest' }} ">{{$menu->badge}}</span>
                            @endif
                        </a>
                            @if (isset($menu->submenu))
                                @include('vuexy.submenu', ['menu' => $menu->submenu])
                            @endif
                    </li>
                    @endif
                @endforeach
            @endif
        </ul> --}}
    </div>
</div>
