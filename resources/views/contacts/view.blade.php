@extends('layouts.main')

@section('styles')
    <link href="{{ asset('admin/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <!--begin::Card-->
    <div class="container">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                <span class="card-icon">
                    <i class="flaticon2-supermarket text-primary"></i>
                </span>
                    <h3 class="card-label">Contacts</h3>
                </div>
                <div class="card-toolbar">
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


    DataTableHelper.initDatatable('#datatable', [1, 'desc'], 'POST', '{{ adminUrl('contacts/list') }}', [
            {
                title: 'Seen',
                data: 'id', render: function(data, type, row)
                {
                    
                    if(row.seen == 1){
                        var html = `<button class="btn btn-sm btn-clean btn-icon" style="cursor: default"disabled>Seen!</button>`
                    }else{
                        var html = `<button data-id="${row.id}"  onClick="seen(event)" class="btn btn-sm btn-clean btn-icon" title="Seen"><i data-id="${row.id}"  onClick="seen(event)" class="la la-eye"></i></button>`;
                    }
                  
                    return html;
                }
            },
            {
                title: 'ID',
                data: 'id'
            },
            {
                title: 'Name',
                data: 'name',
                render: function(data, type, row){
                    
                    return data ? data : '';

                } 

            },
            {
                title: 'Email',
                data: 'email',
                render: function(data, type, row){
                    
                    return data ? data : '';

                } 
            },
            {
                title: 'Message',
                data: 'message',
                render: function(data, type, row){
                    
                    return data ? data : "";

                } 
            },
            {
                title: 'Phone Number',
                data: 'phone_number',
                render: function(data, type, row){
                    
                 

                    return data ? data : '';


                } 

            },
            {
                title: 'User IP',
                data: 'user_ip',
                render: function(data, type, row){

                    return data ? data : '';

                } 

            },
            {
                title: 'Created at',
                data: 'created_at', render: function(data) {
                    return  moment(data).format('YYYY-MM-DD HH:mm:ss');
                }
            },
            @can('contact:update')
            {
                    title: 'Edit',
                    data: 'id',
                    sWidth:'1px',
                    orderable: false,
                    render: function(data, type, row)
                    {
                        let  html = '<a href="{{ adminUrl('contacts') }}/'+ data +'/edit" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="la la-edit"></i></a>';
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
                        let  html = '<button onclick="DataTableHelper.deleteRecord(\'{{ adminUrl('contacts') }}/'+ data +'\')" class="btn btn-sm btn-clean btn-icon" title="Delete"><i class="la la-remove"></i></button>';
                        return data ? html : "";
                    }
                },             
         
            @endcan

    
    
        ],
        false,
        [{width:20, searchable: false, targets: [0]}]);





        let adminUrl = '<?= env('ADMIN_URL') ?>';

    
        function seen(event){

        let id = event.target.dataset.id;
        console.log(id)
        $.ajax({
            url: `/${adminUrl}/seen`,
            type: 'POST',
            data: {
                id: id,
                model: "Contact"
            },
            success: function(response){
                DataTableHelper.updateTable();
            },
            error: function(response){
            }
        })

        }

</script>
@endsection
