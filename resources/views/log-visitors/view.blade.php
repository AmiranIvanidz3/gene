@extends('layouts.main')

@section('styles')
    <link href="{{ asset('admin/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@php
  
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
                        <h3 class="card-label">Visitors</h3>
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

       DataTableHelper.initDatatable('#datatable', [1, 'desc'], 'POST', '{{ adminUrl('log-visitors/list') }}', [
             
                {
                    title: 'ID / IP / Session',
                    data: 'ip',
                    render: function(data, type, row)
                    {
                        let html = `<span style="text-align:center;">${row.id}</span><br>`

                        html += `<a href="/${admin_url}/log-visitors?ip=${data}">${data}</a><br>`;

                        var firstSixChars = row.session_id ?row.session_id.substring(0, 12) : "";

                        html += `<a href="/${admin_url}/log-visitors?session=${row.session_id}">${firstSixChars}</a><br>`;

                        return html;
                    }
                },
                {
                    title: 'Created At',
                    data: 'created_at',
                    render: function(data, type, row)
                    {

                        let date = moment(data).format('YYYY-MM-DD')
                        let time = moment(data).format('HH:mm:ss')

                        let html = `<a href="/${admin_url}/log-visitors?created=${data}">${date}</a><br>`;
                        html += `<a href="/${admin_url}/log-visitors?created=${data}">${time}</a>`;

                        return html;
                    }
                },   
                {
                    title: 'Query String / Info',
                    data: 'query_string',
                    sWidth:100,
                    render: function(data, type, row)
                    {
                        let queryAndReferrer = data && row.referrer;
                        let str_cut = @json(intval($referrer_letters_count));
                        

                        html = `
                            ${data ? `<p title=${data.length >= str_cut ? data : "" }><span class="text-danger">Q: </span>${data.length >= str_cut ? data.substring(0,str_cut)+"..."  : data}</p>` : ""}
                            ${queryAndReferrer ? "<hr>" : ""}
                            ${row.referrer ? `<p title=${row.referrer.length >= str_cut ? row.referrer : "" }><span class="text-danger">R: </span>${row.referrer.length >= str_cut ? row.referrer.substring(0,str_cut)+"..."  : row.referrer}</p>` : ""}
                        `
                        return html;
                    }
                },
                {
                    title: 'User Agent',
                    data: 'user_agent',
                    sWidth:200,
                    render: function(data, type, row)
                    {
                        let string = data ? data.replaceAll(';','; ') : "";
                        return data ? string : "";
                    }
                },
                {
                    title: ' Page',
                    data: 'page',
                    sWidth:'1px',
                    render: function(data, type, row)
                    {

                        let html = `<span style="color:red;">${data ? data : ""}</span><br>`
                        
                       

                        return html;
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
