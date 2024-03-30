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
    $menu['ua-logs']['date-group-log-ua'] = true;

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
                        <h3 class="card-label">Group Date IPs</h3>
                    </div>
                    <div class="card-toolbar">
                </div>
            </div>
            <div class="card-body">
                <x-log-filter/>
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



       DataTableHelper.initDatatable('#datatable', [0, 'desc'], 'POST', '{{ adminUrl('group-log-ua/list/2') }}', [
                {
                    title: 'Date',
                    data: 'date',
                    sWidth:200,
                    render: function(data, type, row)
                    {
                        let formatedData = moment(data).format('YYYY-MM-DD')
                        let html = `<a href="/${admin_url}/group-log-ip/ip?created=${formatedData}">
                            ${formatedData}
                        </a>`;
                        
                        return  data ? html : "";
                    }
                },
              
                {
                    title: 'Count Hosts',
                    data: 'cnt',
                    render: function(data, type, row)
                    {

                        return data ? data : "";
                    }
                },
                {
                    title: 'Count Hits',
                    data: 'total_cnt',
                    render: function(data, type, row)
                    {

                        let formatedData = moment(row.date).format('YYYY-MM-DD')
                        let html = `<a href="/${admin_url}/log-visitors?from=${formatedData}&to=${formatedData}">
                            ${data}
                        </a>`;

                        return data ? html : "";
                    }
                },
            ],
            false,
            [{width:20, searchable: false, targets: [0]}]);



    </script>
@endsection
