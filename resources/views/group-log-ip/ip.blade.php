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
    $menu['ip-logs']['group-log-ip'] = true;

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
                        <h3 class="card-label">Group IPs</h3>
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
       

       DataTableHelper.initDatatable('#datatable', [2, 'desc'], 'POST', '{{ adminUrl('group-log-ip/list/1')}}', [
                    {
                        title: 'IP',
                        data: 'ip',
                        sWidth: 300,
                        render: function(data, type, row){
                            let html = `<a href="/${admin_url}/log-visitors?ip=${row.ip}">
                                            ${data}
                                        </a>`

                            return data ? html : "";
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
                        data: 'count',
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

                            let html = `<a href="/${admin_url}/log-visitors?ip=${row.ip}${date}">
                                            ${data}
                                        </a>`
                            return data ? html : "";
                        }
                    },
                    {
                        title: 'Group',
                        data: 'ip',
                        render: function(data, type, row){
                            let html = `<button onClick="excludeIp('${data}')" class="btn btn-danger">Group</button>`
                            return data ? html : "";
                        }
                    },
                    
            ],
            false,
            [{width:20, searchable: false, targets: [0]}]);

    function excludeIp(ip){
        var reason = prompt("Enter the reason:");
        if(reason){
            $.ajax({
                url: `/${admin_url}/exclude-ip`,
                type: 'POST',
                data: {
                    ip: ip,
                    message: reason
                },
                success: function(response){
                    DataTableHelper.updateTable();
                },
                error: function(response){
                }
            })
        }
    }

    $(document).ready(function() {
                $('.datatable-filter').each(function() {
                    if ($(this).val() != '') {
                        $(this).trigger('change');
                    }
                });
            });


    </script>
@endsection
