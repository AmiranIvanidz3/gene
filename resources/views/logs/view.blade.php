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
                <div>
                    <div class="row">
                        <div class="col-lg-3">
                            <label>User</label>
                            <select id="kt_select2_1" class ="form-control datatable-filter" data-live-search="true" data-filter="user_filter" onchange="DataTableHelper.updateFilter(this, 'integer')">
                            <option value = "0" >Select User</option>
                                @foreach ($users as $user)
                                    <option  value="{{ $user->id }}">
                                    {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label>Action</label>
                            <select id="kt_select2_1" class ="form-control datatable-filter" data-live-search="true" data-filter="action_filter" onchange="DataTableHelper.updateFilter(this, 'integer')">
                            <option value = "0" >Select Action</option>
                                @foreach ($actions as $action)
                                    <option  value="{{ $action->id }}">
                                    {{ $action->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12  mt-3 mb-3" >
                            <a href="/{{env('ADMIN_URL')}}/users" class="btn btn-secondary">
                                <span>
                                    <i class="la la-close"></i>
                                    <span>Reset</span>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="m-separator m-separator--md m-separator--dashed"></div>
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
       DataTableHelper.initDatatable('#datatable', [0, 'desc'], 'POST', '{{ adminUrl('logs/list') }}', [
                {
                    title: 'Id',
                    data: 'id',
                    render: function(data, type, row){


                        return data ? data : '';

                    } 
                  
                },
                {
                    title: 'User',
                    data: 'user.name',
                    render: function(data, type, row){

                        return data ? data+" "+row.user.last_name : '';

                    } 
                },
                {
                    title: 'Action',
                    data: 'action.name',
                    render: function(data, type, row){


                        return data ? data : '';

                    } 
                },
                {
                    title: 'Data',
                    data: 'data',
                    render: function(data, type, row){

                        const parser = new DOMParser();
                        const decodedJson = parser.parseFromString(`<!doctype html><body>${data}`, 'text/html').body.textContent;

                        const jsonData = JSON.parse(decodedJson);

                        let html = `Old => ${jsonData?.old} / New => ${jsonData?.new}`;

                        return data ? html : '';

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
                    title: 'Datetime',
                    data: 'datetime',
                    render: function(data, type, row){


                        return data ? data : '';

                    } 
                },
               
               

            ],
            false,
            [{width:20, searchable: false, targets: [0]}]);

    </script>
@endsection
