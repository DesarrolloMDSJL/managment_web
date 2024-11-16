
@extends('vuexy.master')

@section('vendor-style')     
    <link rel="stylesheet" href="{{ asset('vuexy/vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vuexy/vendors/css/tables/datatable/responsive.dataTables.min.css') }}">
@endsection

@section('content')
    <section id="basic-input" >       
        <div class="row form-container">
           <taxes 
                :select-mes-url="'{{ route('select-mes') }}'"
                :select-anno-url="'{{ route('select-anno') }}'"

                :taxes-list-url="'{{ route('taxes-list') }}'"
                :taxes-total-recaudado-tributo-url="'{{ route('taxes-total-recaudado-tributo') }}'"
                :taxes-total-recaudado-mes-tributo-url="'{{ route('taxes-total-recaudado-mes-tributo') }}'"
                :taxes-ingreso-mes-tributo-url="'{{ route('taxes-ingreso-mes-tributo') }}'"
                :taxes-recorrido-dia-tributo-url="'{{ route('taxes-recorrido-dia-tributo') }}'"
                :taxes-list-tributo-url="'{{ route('taxes-list-tributo') }}'"
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