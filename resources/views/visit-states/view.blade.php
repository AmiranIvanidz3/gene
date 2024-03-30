@extends('layouts.main')

@php
    $filters = [
                    'id' => 'ID',
                    'name' => 'Name',
                    'comment' => 'Comment',
                ];
@endphp

@section('styles')
    <link href="{{ asset('admin/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <!--begin::Card-->
    <div class="container">
        <div class="card card-custom">
            <div class="card-header">
                @can('parameter:add')
                    <div class="card-toolbar">
                        <!--begin::Button-->
                        <a href="{{ url(adminUrl('visit-states/create')) }}" class="btn btn-primary font-weight-bolder">
                            <i class='flaticon-add'></i> {{\App\Models\Parameter::getValue('create_new')}}
                        </a>
                        <!--end::Button-->
                    </div>
                @endcan
            </div>
            <div class="card-body">
                <div class="filters">
                    <div class="row ">
                        <div style="display:flex; flex-wrap:wrap">
                            <div class="col-2 mb-5 search_div">
                                <label>From</label>
                                <input id="from" type="date" class="form-control datatable-filter" @if(isset($_GET['created'])) value="{{substr($_GET['created'],0,10)}}" @endif value="{{ isset($_GET['from']) ? $_GET['from'] : "" }}" data-live-search="true" data-filter="from_date_filter" onchange="DataTableHelper.updateFilter(this, 'string')">
                            </div>

                            <div class="col-2 mb-5 search_div">
                                <label>To</label>
                                <input id="to" type="date" class="form-control datatable-filter" @if(isset($_GET['created'])) value="{{substr($_GET['created'],0,10)}}" @endif value="{{ isset($_GET['to']) ? $_GET['to'] : "" }}" data-live-search="true" data-filter="to_date_filter" onchange="DataTableHelper.updateFilter(this, 'string')">
                            </div>
                            @foreach ($filters as $filterName => $filterLabel)
                                <div class="col-2 mb-5 search_div">
                                    <label>{{ $filterLabel }}</label>
                                    <input type="text" id="{{$filterName}}" class="form-control datatable-filter {{ $filterName }} " @if(isset($_GET[$filterName])) value="{{$_GET[$filterName]}}" @endif data-live-search="true" data-filter="{{ $filterName }}" placeholder="{{ $filterLabel }}" onchange="DataTableHelper.updateFilter(this, 'string')">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12  mt-3 mb-3" >
                            <a class="btn btn-secondary" href="{{ url()->current() }}">
                                <span><i class="la la-close"></i><span>Reset</span></span>
                            </a>
                        </div>
                    </div>
                    <div class="m-separator m-separator--md m-separator--dashed"></div>
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

<script>


    DataTableHelper.initDatatable('#datatable', [0, 'desc'], 'POST', '{{ adminUrl('visit-states/list') }}', [
            {
                title: 'ID',
                data: 'id',
                render: function(data, type, row)
                {

                    return data;
                    
                }
            }, 
            {
                title: 'Name',
                data: 'name',
                render: function(data, type, row)
                {

                    return data;
                    
                }
            },
            {
                title: 'Comment',
                data: 'comment',
                render: function(data, type, row)
                {

                    return data;
                    
                }
            },
            {
                title: 'Edit',
                data: 'id',
                sWidth:'1px',
                orderable: false,
                render: function(data, type, row)
                {
                    let  html = '<a href="{{ adminUrl('visit-states') }}/'+ data +'/edit" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="la la-edit"></i></a>';
                    return data ? html : "";
                }
            },
            {
                title: 'Del',
                data: 'id',
                sWidth:'1px',
                orderable: false,
                render: function(data, type, row)
                {
                    let  html = '<button onclick="DataTableHelper.deleteRecord(\'{{ adminUrl('visit-states') }}/'+ data +'\')" class="btn btn-sm btn-clean btn-icon" title="Delete"><i class="la la-remove"></i></button>';
                    return data ? html : "";
                }
            },
        ],
        false,
        [{width:20, searchable: false, targets: [0]}]);





    
</script>
@endsection
