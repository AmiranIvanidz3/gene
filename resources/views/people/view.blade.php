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
                        <a href="{{ url(adminUrl('people/create')) }}" class="btn btn-primary font-weight-bolder">
                            <i class='flaticon-add'></i> {{\App\Models\Parameter::getValue('create_new')}}
                        </a>
                        <!--end::Button-->
                    </div>
                @endcan
            </div>
            <div class="card-body">
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


    DataTableHelper.initDatatable('#datatable', [0, 'desc'], 'POST', '{{ adminUrl('people/list') }}', [
            {
                title: 'ID',
                data: 'id',
                render: function(data, type, row)
                {

                    return data;
                    
                }
            }, 
            {
                title: 'Mother',
                data:'id',
                render: function(data, type, row)
                {

                    return row.mother ? row.mother.name : "";
                    
                }
            }, 
            {
                title: 'Father',
                data: 'id',
                render: function(data, type, row)
                {

                    return row.father ? row.father.name : "";
                    
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
                title: 'Surname',
                data: 'surname',
                render: function(data, type, row)
                {

                    return data;
                    
                }
            }, 
            {
                title: 'Gender ID',
                data: 'gender_id',
                render: function(data, type, row)
                {

                    return (data == 1) ? 'Male' : 'Female';
                    
                }
            }, 
            {
                title: 'Birth Date',
                data: 'birth_date',
                render: function(data, type, row)
                {

                    return data;
                    
                }
            }, 
            {
                title: 'Personal Number',
                data: 'personal_number',
                render: function(data, type, row)
                {

                    return data;
                    
                }
            }, 
            {
                title: 'About',
                data: 'about',
                render: function(data, type, row)
                {

                    return data;
                    
                }
            }, 
            {
                title: 'Comment',
                data: 'comment',
                render: function(data, type, row)
                {

                    return data;
                    
                }
            }, 
            {
                title: 'Died',
                data: 'died',
                render: function(data, type, row)
                {
                    
                    return data;
                    
                }
            }, 
            {
                title: 'Edit',
                data: 'id',
                sWidth:'1px',
                orderable: false,
                render: function(data, type, row)
                {
                    let  html = '<a href="{{ adminUrl('people') }}/'+ data +'/edit" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="la la-edit"></i></a>';
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
                    let  html = '<button onclick="DataTableHelper.deleteRecord(\'{{ adminUrl('people') }}/'+ data +'\')" class="btn btn-sm btn-clean btn-icon" title="Delete"><i class="la la-remove"></i></button>';
                    return data ? html : "";
                }
            },
        ],
        false,
        [{width:20, searchable: false, targets: [0]}]);





    
</script>
@endsection
