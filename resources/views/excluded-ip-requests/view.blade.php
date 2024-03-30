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
                    <h3 class="card-label">Excluded IP Requests</h3>
                </div>
                <div class="card-toolbar">
                    <!--begin::Button-->
 
                    <!--end::Button-->
                </div>
            </div>
            <div class="card-body">
                <div>
                    <div class="row ">
                
                        <div class="col-lg-2">
                            <label>From</label>
                            <input id = "from" type="date" class="form-control datatable-filter" @if(isset($_GET['created'])) value="{{substr($_GET['created'],0,10)}}"  @endif data-live-search="true" data-filter="from_date_filter" onchange="DataTableHelper.updateFilter(this, 'string');">
                        </div>

                        <div class="col-lg-2">
                            <label>To</label>
                            <input id = "to" type="date" class="form-control datatable-filter" @if(isset($_GET['created'])) value="{{substr($_GET['created'],0,10)}}" @endif data-live-search="true" data-filter="to_date_filter" onchange="DataTableHelper.updateFilter(this, 'string');">
                        </div>

                        <div class="col-2 mb-5 search_div">
                            <label>IP</label>
                            <input type="text" class="form-control datatable-filter" @if(isset($_GET['ip'])) value="{{$_GET['ip']}}" @endif data-live-search="true" data-filter="ip_id" placeholder="IP" onchange="DataTableHelper.updateFilter(this, 'string')">
                        </div>

                    </div>
                        <div class="row">
                            <div class="col-lg-12  mt-3 mb-3" >
                                <a href="/{{env('ADMIN_URL')}}/ip-requests" class="btn btn-secondary">
                                    <span>
                                        <i class="la la-close"></i>
                                        <span>Reset</span>
                                    </span>
                                </a>
                            </div>
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
       DataTableHelper.initDatatable('#datatable', [0, 'desc'], 'POST', '{{ adminUrl('ip-requests/list') }}', [
                
                   
                {
                    title: 'ID',
                    data: 'id'
                },
                {
                    title: 'Date',
                    data: 'date',
                    sWidth:200,
                    render: function(data, type, row)
                    {
                        let formatedData = moment(data).format('YYYY-MM-DD')
                        let html = `<a href="/${admin_url}/ip-requests?created=${formatedData}">
                            ${formatedData}
                        </a>`;
                        
                        return  data ? html : "";
                    }
                }, 
                {
                    title: 'IP',
                    data: 'ip.ip',
                    render: function(data, type, row) {
                        let html = `<a href="/${admin_url}/ip-requests?ip=${data}">
                                            ${data}
                                        </a>`

                            return data ? html : "";
                    }
                },
                {
                    title: 'Comment',
                    data: 'ip.comment',
                    render: function(data, type, row) {
                        return data ? data : "";
                    }
                },
                {
                    title: 'Count',
                    data: 'count',
                    render: function(data, type, row) {
                      
                        return data;
                    }
                },
            ],
            false,
            [{width:20, searchable: false, targets: [0]}]);


            
            $(document).ready(function() {
                $('.datatable-filter').each(function() {
                    if ($(this).val() != '') {
                        $(this).trigger('change');
                    }
                });
            });

    </script>
@endsection
