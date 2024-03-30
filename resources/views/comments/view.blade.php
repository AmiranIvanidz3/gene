@extends('layouts.main')

@php
    $user_id = Auth::user()->id;
@endphp

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
                <h3 class="card-label">{{$page_title}}</h3>
                </div>
                <div class="card-toolbar">
                    <!--begin::Button-->

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

var user_id = @json($user_id);

DataTableHelper.initDatatable('#datatable', [0, 'desc'], 'POST', '{{ adminUrl('comments/list') }}', [
     
     { 
         title: 'ID',
         data: 'id', render: function(data, type, row)
         {
            return data ? data : "";
         } 
   
     },
     {
        title: 'Seen',
        data: 'id',
         render: function(data, type, row){
            const exists = row.seen_comment.some(user => user.id === user_id);
            if(exists) {
                var html = '<center>Seen</center>';
            } else {
                var html = `
                <div class="d-flex justify-content-center">
                    <i data-id="${row.id}" onClick="seen(event)" class="la la-eye" style="cursor:pointer; scale:2 "></i>
                </div>
                `;
            }
            return html;
            }
        },
     {
        title: 'Role',
        data: 'user_roles',
        render: function(data, type, row){
            return data ? data : "";
        }
     },
     {
        title: 'Model',
        data: 'model',
        render: function(data, type, row){
            return data ? data : "";
        }
     },
     {
        title: 'Model ID',
        data: 'model_id',
        render: function(data, type, row){
            return data ? data : "";
        }
     },
     {
        title: 'User Name',
        data: 'user.name',
        render: function(data, type, row){
            let html = `${data} ${row.user.last_name}`
            return data ? html : "";
        } 
     },
     {
        title: 'Comment',
        data: 'comment',
        render: function(data, type, row){
            let model = row.model.toLowerCase() + 's';
            let html = `<a target="_blank" href="/${admin_url}/${model}/${row.model_id}/edit">${data}</a>`
            return data ? html : "";
        } 
     },
     {
         title: 'Created At',
         data: 'created_at',
         render: function(data, type, row){
            return moment(data).format('YYYY-MM-DD HH:mm');

         } 
     },
     @if(Auth::user()->hasRole('Admin'))
     {
         title: 'User IP',
         data: 'ip',
         render: function(data, type, row){
             return data ? data : "";

         } 
     },
     @endif
     
    
 ],
 false,
 [{width:20, searchable: false, targets: [0]}]);


 // Comment Seen Function --Start--

 let adminUrl = '<?= env('ADMIN_URL') ?>';
function seen(event){
    let id = event.target.dataset.id;

    $.ajax({
        url: `/${adminUrl}/seen`,
        type: 'POST',
        data: {
            id: id
        },
        success: function(response){
            DataTableHelper.updateTable();
        },
        error: function(response){
        }
    })
}

 // Comment Seen Function --End--



    
</script>
@endsection
