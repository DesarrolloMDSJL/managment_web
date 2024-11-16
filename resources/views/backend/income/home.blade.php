
@extends('vuexy.master')

@section('vendor-style')     
    <link rel="stylesheet" href="{{ asset('vuexy/vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vuexy/vendors/css/tables/datatable/responsive.dataTables.min.css') }}">
@endsection

@section('content')
    <section id="basic-input" >       
        <div class="row form-container">
           <income 
                :select-mes-url="'{{ route('select-mes') }}'"
                :select-anno-url="'{{ route('select-anno') }}'"

                :income-total-recaudado-url="'{{ route('income-total-recaudado') }}'"
                :income-total-ingreso-mes-url="'{{ route('income-total-ingreso-mes') }}'"
                :income-ingreso-partida-general-url="'{{ route('income-ingreso-partida-general') }}'"
                :income-total-ingreso-detallado-url="'{{ route('income-total-ingreso-detallado') }}'"
                :income-reporte-ingreso-detallado-url="'{{ route('income-reporte-ingreso-detallado') }}'"
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