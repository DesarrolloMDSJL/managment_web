
@extends('vuexy.login_master')

@section('page-style')
<link rel="stylesheet" href="{{ asset('vuexy/css/pages/page-auth.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">
@endsection

@section('content')
<div class="auth-wrapper auth-v2">
    <div class="auth-inner row m-0">
 {{--        <a class="brand-logo" href="javascript:void(0);">
            <svg viewBox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="28">
                <defs>
                    <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                        <stop stop-color="#000000" offset="0%"></stop>
                        <stop stop-color="#FFFFFF" offset="100%"></stop>
                    </lineargradient>
                    <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
                        <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                        <stop stop-color="#FFFFFF" offset="100%"></stop>
                    </lineargradient>
                </defs>
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                        <g id="Group" transform="translate(400.000000, 178.000000)">
                            <path class="text-primary" id="Path" d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z" style="fill: currentColor;color: #34A0B3 !important"></path>
                            <path id="Path1" d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z" fill="url(#linearGradient-1)" opacity="0.2"></path>
                            <polygon id="Path-2" fill="#000000" opacity="0.049999997" points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
                            <polygon id="Path-21" fill="#000000" opacity="0.099999994" points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
                            <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994" points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                        </g>
                    </g>
                </g>
            </svg>
            <h2 class="brand-text text-primary ml-1" style="color: #34A0B3 !important">REPORTE GERENCIALES</h2>
        </a> --}}
        <!-- /Brand logo-->
        <!-- Left Text-->
        <div class="d-none d-lg-flex col-lg-8 align-items-center p-5" 
           style="background-image: url('./images/fondo-login.jfif'); 
            background-size: cover;
            background-position: center;"> 
            {{-- style="background-image: url('./images/fondo-login.jfif');
            opacity: 1 !important;
            background-repeat: repeat;
            
            " --}}

            {{-- background-image: url('./recursos-sjl/eec-virtual-images/imagen_login_inicio.png'); background-size: cover; background-position: center; --}}
            {{-- <img src="{{ asset('images/fondo-login.jfif') }}" alt="" style="width: 120%">                                                                             --}}
            <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                {{-- <img class="img-fluid"  
                src="{{ asset('images/fondo-login.jfif') }}" alt="Login V2" /> --}}
            </div>
        </div>
        <!-- /Left Text-->
        <!-- Login-->
        {{--  {{}} --}}
        <login :url="'{{ route('login') }}'" 
                :dashboard="'{{ route('dashboard') }}'"  
                :report="'{{ route('report') }}'"
               {{--  :icon-logo="'{{ asset('/images/fondo-login.jfif') }}'" --}}
                > </login>
        {{--  <login :url="'{{ route('login')'"> </login> --}}
        <!-- /Login-->
    </div>
</div>
@endsection
