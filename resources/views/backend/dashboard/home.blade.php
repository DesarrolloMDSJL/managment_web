
@extends('vuexy.master')

@section('vendor-style')     
    <link rel="stylesheet" href="{{ asset('vuexy/vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vuexy/vendors/css/tables/datatable/responsive.dataTables.min.css') }}">
@endsection

@section('content')
    <section id="basic-input" >   
        <div class="row form-container mt-5">
           <dashboard 
                :percentage-total-url="'{{ route('percentage-total') }}'"
                :select-mes-url="'{{ route('select-mes') }}'"
                :select-anno-url="'{{ route('select-anno') }}'"
                :select-total-ingreso-tupa-tusne-url="'{{ route('select-total-ingreso-tupa-tusne') }}'"
                :select-top-recaudacion-area-url="'{{ route('select-top-recaudacion-area') }}'"
                :select-total-ingreso-mes-multas-url="'{{ route('select-total-ingreso-mes-multas') }}'"
                :select-recaudacion-mes-multas-url="'{{ route('select-recaudacion-mes-multas') }}'"
                :select-total-ingreso-mes-tributaria-url="'{{ route('select-total-ingreso-mes-tributaria') }}'"
                :select-recaudacion-mes-tributaria-url="'{{ route('select-recaudacion-mes-tributaria') }}'"
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