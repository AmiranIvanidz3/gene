@extends('layouts.main')

@section('styles')
    <link href="{{ asset('admin/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection



@php
    
    $group = '';

    if(isset($_GET['group'])){
        $group = $_GET['group'];
    }


    $filtersv2 = [
                    'ip',
                    'session',
                    'reel',
                    'query_string',
                    'referrer',
                    'author',
                    'user_agent_id',
                    'check_fb_clid',
                    'check_fb',
                    'check_yt',
                    'check_g',
                    'from',
                    'to',
                ];

 
    $menu = [];
    $menu['ip-logs']['date-group-log-ip'] = true;

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

        let filters = @json($filtersv2);
        var currentDate = new Date();
        currentDate.setMonth(currentDate.getMonth() - 1);
        var dateString = currentDate.toISOString().slice(0,10);
        document.getElementById('from').value = dateString;

       DataTableHelper.initDatatable('#datatable', [0, 'desc'], 'POST', '{{ adminUrl('group-log-ip/list/2') }}', [
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
                    title: 'Count Sessions',
                    data: 'session_cnt',
                    render: function(data, type, row)
                    {
                        return data ? data : "";
                    }
                },
                {
                    title: 'Count Hits',
                    data: 'total_cnt',
                    render: function(data, type, row, input)
                    {


                        let html = `<button onclick="getLink('${row.date}')" style="color:blue">
                            ${data}
                        </button>`;



                        return data ? html : "";
                    }
                },
            ],
            false,
            [{width:20, searchable: false, targets: [0]}]);


    function getLink(created){


        let link = `/${admin_url}/log-visitors?created=${created}`;

        filters.forEach(function(id) {

            var element = document.getElementById(id);
            if (element) {
                if(element.value && element.value != 'on'){
                    link += `&${id}=${element.value}`;
                }
            }
        });

        window.location.href = link;

    }

                

    </script>
@endsection
