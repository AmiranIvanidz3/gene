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
                    <a href="{{ url('/'.env('ADMIN_URL').'/excluded-ips/create') }}" class="btn btn-primary font-weight-bolder">
                        <i class='flaticon-add'></i> {{\App\Models\Parameter::getValue('create_new')}}
                    </a>

                    <!--end::Button-->
                </div>
            </div>
            <div class="card-body">
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
       DataTableHelper.initDatatable('#datatable', [0, 'desc'], 'POST', '{{ adminUrl('excluded-ips/list') }}', [
                    {
                    title: 'ID',
                    data: 'id',
                    render: function(data, type, row)
                    {
                        let html = `<span style="margin-left:11px;">${data}</span>`
                        return html;
                    }
                },
                {
                    title: 'IP',
                    data: 'ip'
                },
                {
                    title: 'Comment',
                    data: 'comment'
                },
                {
                    title: 'Edit',
                    data: 'id',
                    sWidth:'1px',
                    orderable: false,
                    render: function(data, type, row)
                    {
                        let  html = '<a href="{{ adminUrl('excluded-ips') }}/'+ data +'/edit" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="la la-edit"></i></a>';
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
                        let  html = '<button onclick="DataTableHelper.deleteRecord(\'{{ adminUrl('excluded-ips') }}/'+ data +'\')" class="btn btn-sm btn-clean btn-icon" title="Delete"><i class="la la-remove"></i></button>';
                        return data ? html : "";
                    }
                },

               

            ],
            false,
            [{width:20, searchable: false, targets: [0]}]);

    </script>
@endsection
