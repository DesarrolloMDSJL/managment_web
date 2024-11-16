
@extends('vuexy.master')

@section('vendor-style')     
    <link rel="stylesheet" href="{{ asset('vuexy/vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vuexy/vendors/css/tables/datatable/responsive.dataTables.min.css') }}">
@endsection

@section('content')
    <section id="basic-input" >       
        <div class="row form-container">
           <fines 
                :select-mes-url="'{{ route('select-mes') }}'"
                :select-anno-url="'{{ route('select-anno') }}'"

                :fines-cuis-ras-url="'{{ route('fines-cuis-ras') }}'"
                :fines-total-recaudado-cuis-ras-url="'{{ route('fines-total-recaudado-cuis-ras') }}'"
                :fines-total-recaudado-mes-cuis-ras-url="'{{ route('fines-total-recaudado-mes-cuis-ras') }}'"
                :fines-ingreso-mes-cuis-ras-url="'{{ route('fines-ingreso-mes-cuis-ras') }}'"
                :fines-recorrido-dia-cuis-ras-url="'{{ route('fines-recorrido-dia-cuis-ras') }}'"
                :fines-list-cuis-ras-url="'{{ route('fines-list-cuis-ras') }}'"
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