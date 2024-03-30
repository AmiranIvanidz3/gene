@extends('layouts.main')

@section('styles')
    <link href="{{ asset('admin/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <!--begin::Card-->
    <div class="container">
        <div class="card card-custom">
            <div class="card-header">
                @can('parameter:add')
                    <div class="card-toolbar">
                        <!--begin::Button-->
                        <a href="{{ url(adminUrl('products/create')) }}" class="btn btn-primary font-weight-bolder">
                            <i class='flaticon-add'></i> {{\App\Models\Parameter::getValue('create_new')}}
                        </a>
                        <!--end::Button-->
                    </div>
                @endcan
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


    DataTableHelper.initDatatable('#datatable', [0, 'desc'], 'POST', '{{ adminUrl('products/list') }}', [
            {
                title: 'ID',
                data: 'id',
                render: function(data, type, row)
                {

                    return data;
                    
                }
            }, 
            {
                title: 'Name',
                data: 'name',
                render: function(data, type, row)
                {

                    return data;
                    
                }
            },
            {
                title: 'Code',
                data: 'code',
                render: function(data, type, row)
                {

                    return data ? data : "";
                    
                }
            },
            {
                title: 'Bar Code',
                data: 'bar_code',
                render: function(data, type, row)
                {

                    return data ? data : "";
                    
                }
            },
            {
                title: 'Interval Code',
                data: 'internal_code',
                render: function(data, type, row)
                {

                    return data ? data : "";
                    
                }
            },
            {
                title: 'Unit Type',
                data: 'unit_type.name',
                render: function(data, type, row)
                {

                    return data ? data : "";
                    
                }
            },
            {
                title: 'Product Type',
                data: 'product_type.name',
                render: function(data, type, row)
                {
                    console.log(row)

                    return data ? data : "";
                    
                }
            },
            {
                title: 'Edit',
                data: 'id',
                sWidth:'1px',
                orderable: false,
                render: function(data, type, row)
                {
                    let  html = '<a href="{{ adminUrl('products') }}/'+ data +'/edit" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="la la-edit"></i></a>';
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
                    let  html = '<button onclick="DataTableHelper.deleteRecord(\'{{ adminUrl('products') }}/'+ data +'\')" class="btn btn-sm btn-clean btn-icon" title="Delete"><i class="la la-remove"></i></button>';
                    return data ? html : "";
                }
            },
        ],
        false,
        [{width:20, searchable: false, targets: [0]}]);





    
</script>
@endsection
