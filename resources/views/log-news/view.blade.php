@extends('layouts.main')

@section('styles')
    <link href="{{ asset('admin/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="container">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                <span class="card-icon">
                    <i class="flaticon2-supermarket text-primary"></i>
                </span>
                    <h3 class="card-label">Actions</h3>
                </div>
                <div class="card-toolbar">
                </div>
            </div>
            <div class="card-body">

                <div class="row">

                    <div class="col-2 mb-5 search_div">
                        <label>Author</label>
                        <select  class="form-control datatable-filter" data-live-search="true" data-filter="user_filter" id="kt_select2_1" onchange="DataTableHelper.updateFilter(this, 'integer')">
                        <option value="0">Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach 
                        </select>
                    </div>

                    <div class="col-2 mb-5 search_div">
                        <label>New</label>
                        <select  class="form-control datatable-filter" data-live-search="true" data-filter="new_filter" id="kt_select2_2" onchange="DataTableHelper.updateFilter(this, 'integer')">
                        <option value="0">Select New</option>
                            @foreach ($news as $new)
                                <option value="{{ $new->id }}">{{ $new->title }}</option>
                            @endforeach 
                        </select>
                    </div>
                    <div class="col-2 mb-5 search_div">
                        <label>Cookie</label>
                        <input type="text" class="form-control datatable-filter"  data-live-search="true" data-filter="cookie_filter" placeholder="Cookie" onchange="DataTableHelper.updateFilter(this, 'string')">
                    </div>

                    <div class="col-2 mb-5 search_div">
                        <label>IP</label>
                        <input type="text" class="form-control datatable-filter"  data-live-search="true" data-filter="ip_filter" placeholder="IP" onchange="DataTableHelper.updateFilter(this, 'string')">
                    </div>

                </div>

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
       DataTableHelper.initDatatable('#datatable', [0, 'desc'], 'POST', '{{ adminUrl('log-news/list') }}', [
                {
                    title: 'ID',
                    data: 'id',
                    render: function(data, type, row){
                        console.log(row)
                        return data ? data : '';
                    } 
                  
                },  
                {
                    title: 'User',
                    data: 'user.name',
                    render: function(data, type, row){
                        return data ? data : '';
                    } 
                  
                },
                {
                    title: 'New',
                    data: 'new.title',
                    render: function(data, type, row){
                        return data ? data : '';
                    } 
                  
                },
                {
                    title: 'IP',
                    data: 'ip',
                    render: function(data, type, row){
                        return data ? data : '';
                    } 
                  
                },
                {
                    title: 'Cookie',
                    data: 'cookie',
                    render: function(data, type, row){
                        return data ? data : '';
                    } 
                  
                },
            ],
            false,
            [{width:20, searchable: false, targets: [0]}]);

    </script>
@endsection
