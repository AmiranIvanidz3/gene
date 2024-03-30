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
    $menu['ua-logs']['group-log-ua'] = true;

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
                        <h3 class="card-label">Group User Agents</h3>
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
       

       DataTableHelper.initDatatable('#datatable', [1, 'desc'], 'POST', '{{ adminUrl('group-log-ua/list/1')}}', [
                    {
                        title: 'User Agent',
                        data: 'user_agent',
                        sWidth: 300,
                        render: function(data, type, row){
                            let html = `<a href="/${admin_url}/log-visitors?user_agent=${row.user_agent}">
                                            ${data}
                                        </a>`

                            return data ? html : "";
                        }
                    },
                    {
                        title: 'Count',
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

                            let html = `<a href="/${admin_url}/log-visitors?user_agent=${row.user_agent}${date}">
                                            ${data}
                                        </a>`
                            return data ? html : "";
                        }
                    },
                    {
                        title: 'Group',
                        data: 'user_agent',
                        render: function(data, type, row){
                            let html = `<button onClick="excludeUA('${data}')" class="btn btn-danger">Group</button>`
                            return data ? html : "";
                        }
                    },
                    
            ],
            false,
            [{width:20, searchable: false, targets: [0]}]);

    function excludeUA(user_agent){
        var reason = prompt("Enter the reason:");
        if(reason){
            $.ajax({
                url: `/${admin_url}/exclude-ua`,
                type: 'POST',
                data: {
                    user_agent: user_agent,
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
