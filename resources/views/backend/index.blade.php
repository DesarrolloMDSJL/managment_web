
@extends('vuexy.master')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('vuexy/vendors/css/charts/apexcharts.css') }}">
<link rel="stylesheet" href="{{ asset('vuexy/css/pages/dashboard-ecommerce.css') }}">
<link rel="stylesheet" href="{{ asset('vuexy/css/plugins/charts/chart-apex.css') }}">
@endsection

@section('content')
              

@endsection

@section('vendor-script')
    <script src="{{ asset('vuexy/vendors/js/charts/apexcharts.min.js') }}"></script>
    <!-- <script src="{{ asset('vuexy/vendors/js/charts/apexcharts.min.js') }}"></script> -->

@endsection