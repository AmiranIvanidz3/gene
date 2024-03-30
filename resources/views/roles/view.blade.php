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
                    @can('role:add')
                        <a href="{{ adminUrl('roles/create') }}" class="btn btn-primary font-weight-bolder">
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
        DataTableHelper.initDatatable('#datatable', [1, 'desc'], 'POST', '{{ adminUrl('roles/list') }}', [
               
                {
                    title: 'ID',
                    data: 'id'
                },
                {
                    title: 'Name',
                    data: 'name'
                },
                {
                    title: 'Action',
                    sWidth: 1,
                    data: 'id', 
                    render: function(data, type, row)
                    {
                        let html = '<a href="{{ adminUrl('roles') }}/'+ data +'" class="btn btn-sm btn-clean btn-icon" title="Show"><i class="la la-eye"></i></a>';
                        
                        return html;
                    }
                },
                @can('role:update')
                    {
                        title: 'Edit',
                        data: 'id',
                        sWidth:'1px',
                        orderable: false,
                        render: function(data, type, row)
                        {
                            let  html = '<a href="{{ adminUrl('roles') }}/'+ data +'/edit" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="la la-edit"></i></a>';
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
                            let  html = '<button onclick="DataTableHelper.deleteRecord(\'{{ adminUrl('roles') }}/'+ data +'\')" class="btn btn-sm btn-clean btn-icon" title="Delete"><i class="la la-remove"></i></button>';
                            return data ? html : "";
                        }
                    },
                @endcan
            ],
            false,
            [{searchable: false, targets: [0]}]);
    </script>
@endsection
