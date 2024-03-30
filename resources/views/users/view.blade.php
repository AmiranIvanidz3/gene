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
                    @can("user:add")
                    <a href="{{ adminUrl('users/create') }}" class="btn btn-primary font-weight-bolder">
                        <i class='flaticon-add'></i> {{\App\Models\Parameter::getValue('create_new')}}
                    </a>
                    @endcan
                    <!--end::Button-->
                </div>
            </div>

            <div class="card-body">
                <div>
                    <div class="row">
                        <div class="col-lg-3">
                            <label>Roles</label>
                            <select id="kt_select2_1" class ="form-control datatable-filter" data-live-search="true" data-filter="role_filter" onchange="DataTableHelper.updateFilter(this, 'integer')">
                            <option value = "0" >Select Role</option>
                                @foreach ($roles as $role)
                                    <option  value="{{ $role->id }}">
                                    {{ $role->name }}
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
    <!--end::Card-->
@endsection
@section('js_scripts')

    <script>
        DataTableHelper.initDatatable('#datatable', [0, 'desc'], 'POST', '{{ adminUrl('users/list') }}', [
                {
                    title: 'ID',
                    data: 'id'
                },
                {
                    title: 'Name',
                    data: 'name'
                },
                {
                    title: 'Last Name',
                    data: 'last_name'
                },
                {
                    title: 'Email',
                    data: 'email'
                },
                {
                    title: 'Role',
                    data: 'roles',
                    render: function(data, type, row)
                    {
                       return data ? data : "";
                    }
                },
                {
                    title: 'Created at',
                    data: 'created_at', render: function(data) {
                        return moment(data).format('DD/MM/YYYY HH:mm');
                    }
                },
                @can('user:update')
                    {
                        title: 'Edit',
                        data: 'id',
                        sWidth:'1px',
                        orderable: false,
                        render: function(data, type, row)
                        {
                            let  html = '<a href="{{ adminUrl('users') }}/'+ data +'/edit" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="la la-edit"></i></a>';
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
                            let  html = '<button onclick="DataTableHelper.deleteRecord(\'{{ adminUrl('users') }}/'+ data +'\')" class="btn btn-sm btn-clean btn-icon" title="Delete"><i class="la la-remove"></i></button>';
                            return data ? html : "";
                        }
                    },
                @endcan

            ],
            false,
            [{searchable: false, targets: [0]}]);

            $('#datatable').on('draw.dt', function() {
                $('#datatable tbody').find('tr').each(function() {

                var data = $('#datatable').DataTable().row(this).data();

                if(data){
                    if (data.reset) {
                        $(this).css({
                            'background-color': '#eefaa7',
                        });
                    }
                }

                   
              
                    
                });
            });

    </script>

@endsection
