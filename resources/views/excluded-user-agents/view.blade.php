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
                    @can("platform:add")
                    <a href="{{ url('/'.env('ADMIN_URL').'/excluded-user-agents/create') }}" class="btn btn-primary font-weight-bolder">
                        <i class='flaticon-add'></i> {{\App\Models\Parameter::getValue('create_new')}}
                    </a>
                    @endcan

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
       DataTableHelper.initDatatable('#datatable', [0, 'desc'], 'POST', '{{ adminUrl('excluded-user-agents/list') }}', [
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
                    title: 'User Agent',
                    data: 'user_agent'
                },
                {
                    title: 'Comment',
                    data: 'comment'
                },
                {
                    title: 'Created At',
                    data: 'created_at',
                    render: function(data, type, row)
                    {
                        let date = moment(data).format('YYYY-MM-DD HH:mm:ss');

                        return data ? date : "";
                    }
                },
                {
                    title: 'Edit',
                    data: 'id',
                    sWidth:'1px',
                    orderable: false,
                    render: function(data, type, row)
                    {
                        let  html = '<a href="{{ adminUrl('excluded-user-agents') }}/'+ data +'/edit" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="la la-edit"></i></a>';
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
                        let  html = '<button onclick="DataTableHelper.deleteRecord(\'{{ adminUrl('excluded-user-agents') }}/'+ data +'\')" class="btn btn-sm btn-clean btn-icon" title="Delete"><i class="la la-remove"></i></button>';
                        return data ? html : "";
                    }
                },

               

            ],
            false,
            [{width:20, searchable: false, targets: [0]}]);

    </script>
@endsection
