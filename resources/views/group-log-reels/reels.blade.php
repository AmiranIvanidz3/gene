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
    $menu['logs']['group-log-reels'] = true;

    $month_ago =  now()->subMonth()->format('Y-m-d');

    $created = '';

    if(isset($_GET['created'])){
        $created = $_GET['created'];
    }
   
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
                        <h3 class="card-label">Group Reels</h3>
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

        let created = @json($created);


       DataTableHelper.initDatatable('#datatable', [2, 'desc'], 'POST', '{{ adminUrl('group-log-reels/list/1')}}', [
                    {
                        title: 'Reel ID',
                        data: 'reel_id',
                        sWidth: 10,
                        render: function(data, type, row)
                        {
                            return data ? data : "";
                        }
                    },
                    {
                        title: 'Title',
                        data: 'title',
                        render: function(data, type, row){
                        
                            console.log(row.reel_id);

                            let html = `<a href="/${admin_url}/group-log-reel-statistic?reel=${row.reel_id}">
                                        ${data}
                                    </a>`

                            return data ? html : "";
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
                        let date_from = document.getElementById('from').value;
                        let date_to = document.getElementById('to').value;

                        let date = '';
                        if(created){
                            date = `&created=${created}`;
                        }else{
                            date += date_from ? `&from=${date_from}`: "";
                            date += date_to ? `&to=${date_to}`: "";
                        }

                        let html = `<a href="/${admin_url}/log-visitors?reel=${row.reel_id}${date}">
                                        ${data}
                                    </a>`

                        return data ? html : "";
                    }
                },
                
            ],
            false,
            [{width:20, searchable: false, targets: [0]}]);

            $(document).ready(function() {
                $('.datatable-filter').each(function() {
                    if ($(this).val() != '') {
                        $(this).trigger('change');
                    }
                });
            });

    </script>
@endsection
