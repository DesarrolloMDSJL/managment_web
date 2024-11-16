
@extends('vuexy.master')

@section('vendor-style')     
    <link rel="stylesheet" href="{{ asset('vuexy/vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vuexy/vendors/css/tables/datatable/responsive.dataTables.min.css') }}">
@endsection

@section('content')
    <section id="basic-input" >       
        <div class="row form-container">
           <report 
                :select-mes-url="'{{ route('select-mes') }}'"
                :select-anno-url="'{{ route('select-anno') }}'"

                :report-unidad-organica-url="'{{ route('report-unidad-organica') }}'"
                :report-total-recaudado-unidad-organica-url="'{{ route('report-total-recaudado-unidad-organica') }}'"
                :report-ingreso-mes-unidad-organica-url="'{{ route('report-ingreso-mes-unidad-organica') }}'"
                :report-total-recaudado-mes-unidad-organica-url="'{{ route('report-total-recaudado-mes-unidad-organica') }}'"
                :report-recorido-diario-mes-unidad-organica-url="'{{ route('report-recorido-diario-mes-unidad-organica') }}'"
                :report-recorido-tupa-mes-unidad-organica-url="'{{ route('report-recorido-tupa-mes-unidad-organica') }}'"
                :usuario-id="{{ session('userData')['usu_id'] }}"
                :unidad-id="{{session('userData')->unidad_id}}"
           />
        </div>
    </section>    
@endsection

@section('vendor-script')

    <script src="{{ asset('vuexy/vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
    <script src="{{ asset('vuexy/vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
    <script src="{{ asset('vuexy/vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('vuexy/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
    <script src="{{ asset('vuexy/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vuexy/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
    <script src="{{ asset('vuexy/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('vuexy/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vuexy/vendors/js/tables/datatable/responsive.dataTables.min.js') }}"></script>
  
    
@endsection