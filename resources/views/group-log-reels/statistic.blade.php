@extends('layouts.main')

@section('styles')
    <link href="{{ asset('admin/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@php
    
    $group = '';

    if(isset($_GET['group'])){
        $group = $_GET['group'];
    }

    $menu = [];
    $menu['logs']['date-group-log-reels'] = true;

    $month_ago =  now()->subMonth()->format('Y-m-d');

@endphp

@section('content')
    <!--begin::Card-->
    <div class="container">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon2-supermarket text-primary"></i>
                    </span>
                        <h3 class="card-label">Group Reels Statistic</h3>
                    </div>
                    <div class="card-toolbar">
                </div>
            </div>
            <div class="card-body">
                <div>
                    <div class="row ">
                
                        <div class="col-lg-2">
                            <label>From</label>
                            <input id="from" type="date" class="form-control datatable-filter"  @if(isset($_GET['created'])) value="{{substr($_GET['created'],0,10)}}" @else value="{{$month_ago}}" @endif data-live-search="true" data-filter="from_date_filter" onchange="DataTableHelper.updateFilter(this, 'string')">
                        </div>

                        <div class="col-lg-2">
                            <label>To</label>
                            <input id="to" type="date" class="form-control datatable-filter" @if(isset($_GET['created'])) value="{{substr($_GET['created'],0,10)}}" @endif data-live-search="true" data-filter="to_date_filter" onchange="DataTableHelper.updateFilter(this, 'string')">
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-lg-12  mt-3 mb-3" >
                                <a href="{{ url()->current() }}" class="btn btn-secondary">
                                    <span>
                                        <i class="la la-close"></i>
                                        <span>Reset</span>
                                    </span>
                                </a>
                            </div>
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
    
    <script>

       DataTableHelper.initDatatable('#datatable', [0, 'desc'], 'POST', '{{ adminUrl('group-log-reel-statistic/list') }}', [
                {
                    title: 'Date',
                    data: 'date',
                    sWidth:200,
                    render: function(data, type, row)
                    {
                        let formatedData = moment(data).format('YYYY-MM-DD')
                        let html = `<a href="/${admin_url}/group-log-reels/reels?created=${formatedData}">
                            ${formatedData}
                        </a>`;
                        
                        return  data ? html : "";
                    }
                },
                {
                    title: 'Title',
                    data: 'title',
                    render: function(data, type, row)
                    {
                        return data ? data : "";
                    }
                },
                {
                    title: 'Count Hosts',
                    data: 'total_cnt',
                    render: function(data, type, row)
                    {

                        return data ? data : "";
                    }
                },
                {
                    title: 'Count Hits',
                    data: 'cnt',
                    render: function(data, type, row)
                    {
                        let date_from = row.date;
                        let date_to = row.date;
                        

                        let date = date_from ? `&from=${date_from}`: "";
                        date += date_to ? `&to=${date_to}`: "";

                        let html = `<a href="/${admin_url}/log-visitors?reel=${row.reel_id}${date}">
                                        ${data}
                                    </a>`

                        return data ? html : "";
                    }
                },
            ],
            false,
            [{width:20, searchable: false, targets: [0]}]);


    </script>
@endsection
