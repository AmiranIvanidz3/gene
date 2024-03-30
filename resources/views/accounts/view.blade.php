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
                    @can('account:add')
                    <a href="{{ url('/'.env('ADMIN_URL').'/accounts/create') }}" class="btn btn-primary font-weight-bolder">
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
       DataTableHelper.initDatatable('#datatable', [0, 'asc'], 'POST', '{{ adminUrl('accounts/list') }}', [
        
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
                    title: 'Project',
                    data: 'project.name',
                    render: function(data, type, row) {
                        return data ? data : '';
                    }
                },
                {
                    title: 'Platform',
                    data: 'platform.name',
                    render: function(data, type, row) {
                        return data ? data : '';
                    }
                },
                {
                    title: 'URL',
                    data: 'url'
                },
                {
                    title: 'Comment',
                    data: 'comment',
                    render: function(data, type, row) {
                        return data ? data : '';         
                    }
                },
                {
                    title: 'Account',
                    data: 'platform.logo',
                    render: function(data, type, row) {
                      let html = `<a target="_blank" href="${row.url}"><img src="{{ asset('assets/images/platforms') }}/${data}" alt="Logo" style="max-width: 50px; max-height: 50px;"></a>`;
                      return html ? html : '';                 
                    }
                },
                @can('account:update')
                    {
                        title: 'Edit',
                        data: 'id',
                        sWidth:'1px',
                        orderable: false,
                        render: function(data, type, row)
                        {
                            let  html = '<a href="{{ adminUrl('accounts') }}/'+ data +'/edit" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="la la-edit"></i></a>';
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
                            let  html = '<button onclick="DataTableHelper.deleteRecord(\'{{ adminUrl('accounts') }}/'+ data +'\')" class="btn btn-sm btn-clean btn-icon" title="Delete"><i class="la la-remove"></i></button>';
                            return data ? html : "";
                        }
                    },
                @endcan
            ],
            false,
            [{width:20, searchable: false, targets: [0]}]);

    </script>
@endsection
