<!DOCTYPE html>
<html lang="en" data-textdirection="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CENTRO COSTOS</title>
    <link rel="shortcut icon" type="image/x-icon" href="images/logo/favicon.ico">

    @include('vuexy.styles')

</head>
<style>
    .spinner {
        border: 4px solid rgba(0, 0, 0, 0.1);
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border-left-color: #09f;
    
        animation: spin 1s ease infinite;
    }
    
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
    
        100% {
            transform: rotate(360deg);
        }
    }
    body.semi-dark-layout .main-menu {
        background-color: #34A0B3 !important;
    }
    body.semi-dark-layout .main-menu-content .navigation-main{
        background: #34A0B3 !important;
    }
    body.semi-dark-layout .main-menu-content .navigation-main .nav-item .menu-content li:not(.active) a{
        background: #34A0B3 !important;
    }
    body.semi-dark-layout .main-menu-content .navigation-main .nav-item .menu-content {
        background: #34A0B3 !important;
    }
    body.semi-dark-layout .main-menu-content .navigation-main .nav-item.open a {
        background: rgb(4, 132, 155) !important;
    }
    .main-menu.menu-dark .navigation > li ul .active {
        background: linear-gradient(118deg, #0d7a8d, rgb(4, 132, 155)) !important; 
        box-shadow: 0 0 10px 1px rgb(4, 132, 155) !important; 
        border-radius: 4px;
    }
    .main-menu.menu-dark .navigation > li.active > a {
        box-shadow: 0 0 10px 1px rgb(4, 132, 155) !important; 
    }
    .main-menu.menu-dark .navigation > li.active > a {
        background: linear-gradient(118deg, #0d7a8d, rgb(4, 132, 155)) !important;
        box-shadow: 0 0 10px 1px rgb(4, 132, 155) !important; 
        color: #fff;
        font-weight: 400;
        border-radius: 4px;
    }
    .main-menu .navbar-header .navbar-brand .brand-logo {
       /*  background: url(../images/logo/vuexy-logo.png) no-repeat; */
        background-position: -120px -54px !important;
        height: 24px;
        width: 35px;
    }
    .btn-primary {
        border-color: #34A0B3 !important;
        background-color: #34A0B3 !important;
    }
    .btn-primary:hover {
        border-color: #34A0B3 !important;
        color: #fff !important;
        box-shadow: 0 8px 25px -8px #34A0B3;
    }
</style>
@extends('vuexy.vertical')