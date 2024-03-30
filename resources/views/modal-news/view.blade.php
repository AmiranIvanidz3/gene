@extends('layouts.main')

@section('styles')
    <link href="{{ asset('admin/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <!--begin::Card-->
    <div class="container">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-toolbar">
                    <!--begin::Button-->
                    {{-- @can("book:add") --}}
                    <a href="{{ url('/'.env('ADMIN_URL').'/modal-news/create') }}" class="btn btn-primary font-weight-bolder">
                        <i class='flaticon-add'></i> {{\App\Models\Parameter::getValue('create_new')}}
                    </a>
                    {{-- @endcan --}}

                    <!--end::Button-->
                </div>
            </div>
            <div class="card-body">
                <div class="row">

                <div class="col-2">
                    <label for="" class="d-block">Active</label>
                    <input type="checkbox" style="width:30px; height:30px" data-live-search="true" data-filter="active_filter" onchange="checkbox(event);DataTableHelper.updateFilter(this, 'integer')">
                </div>
                
                </div>
                
               <!--begin: Datatable-->
               <table class="table table-bordered table-hover table-checkable" id="datatable"></table>
                <!--end: Datatable-->
            </div>
       </div>

    </div>
    <!--end::Container-->
     <!--end::Card-->
@endsection

@section('js_scripts')

   @include('modal-news.table')
   

@endsection
