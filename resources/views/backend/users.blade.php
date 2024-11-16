
@extends('vuexy.master')

@section('vendor-style')     
    <link rel="stylesheet" href="{{ asset('vuexy/vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vuexy/vendors/css/tables/datatable/responsive.dataTables.min.css') }}">
@endsection

@section('content')
    <section id="basic-input" >       
        <div class="row form-container">
            <div class="col-md-12">
                <user-form
                    :route="'{{ route('admin.users.ct') }}'"
                    :areas = "{{ $areas}}"            
                >
                </user-form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Listado usuarios</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <user-table
                                :url-list="'{{ route('admin.users.list') }}'"
                                :url-detail="'{{ route('admin.users.detail') }}'"
                                :url-delete="'{{ route('admin.users.delete') }}'"
                            >
                            </user-table>
                        </div>
                    </div>
                </div>
            </div>
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