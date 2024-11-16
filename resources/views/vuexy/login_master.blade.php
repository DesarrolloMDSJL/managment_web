<!DOCTYPE html>
<html lang="en" data-textdirection="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>LOGIN | CENTRO COSTOS</title>
    <link rel="shortcut icon" href="images/favicon.png">
    @include('vuexy.styles')

</head>

@extends('vuexy.login_vertical')

<style>
.btn-primary {
    border-color: #34A0B3 !important;
    background-color: #34A0B3 !important;
}
.btn-primary:hover {
    border-color: #34A0B3 !important;
    color: #fff !important;
    box-shadow: 0 8px 25px -8px #34A0B3;
}
body.vertical-layout.vertical-menu-modern.menu-collapsed .app-content, body.vertical-layout.vertical-menu-modern.menu-collapsed .footer {
    margin-left: 0px !important;
}
</style>