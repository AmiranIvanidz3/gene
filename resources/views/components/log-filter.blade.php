<div class="filters">
    <div>
        <div>
            <div class="row ">

                <div style="display:flex; flex-wrap:wrap">
                    <div class="col-2 mb-5 search_div">
                        <label>From</label>
                        <input id="from" type="date" class="form-control datatable-filter" @if(isset($_GET['created'])) value="{{substr($_GET['created'],0,10)}}" @endif value="{{ isset($_GET['from']) ? $_GET['from'] : "" }}" data-live-search="true" data-filter="from_date_filter" onchange="DataTableHelper.updateFilter(this, 'string')">
                    </div>

                    <div class="col-2 mb-5 search_div">
                        <label>To</label>
                        <input id="to" type="date" class="form-control datatable-filter" @if(isset($_GET['created'])) value="{{substr($_GET['created'],0,10)}}" @endif value="{{ isset($_GET['to']) ? $_GET['to'] : "" }}" data-live-search="true" data-filter="to_date_filter" onchange="DataTableHelper.updateFilter(this, 'string')">
                    </div>
                    @foreach ($filters as $filterName => $filterLabel)
                        <div class="col-2 mb-5 search_div">
                            <label>{{ $filterLabel }}</label>
                            <input type="text" id="{{$filterName}}" class="form-control datatable-filter {{ $filterName }} " @if(isset($_GET[$filterName])) value="{{$_GET[$filterName]}}" @endif data-live-search="true" data-filter="{{ $filterName }}_id" placeholder="{{ $filterLabel }}" onchange="DataTableHelper.updateFilter(this, 'string')">
                        </div>
                    @endforeach

                    <div class="col-2 mb-5 search_div d-flex" style="justify-content:space-between">

                        <div>
                            <label class="d-block">FB-clid</label>
                            <input id="check_fb_clid" class="check" type="checkbox" style="width:42px; height:35px;" onchange="checkFilter(event, 'fbclid=', 'query_string')"> 
                        </div>

                        <div>
                            <label class="d-block text-center">FB</label>
                            <input id="check_fb" class="check" type="checkbox" style="width:42px; height:35px;" onchange="checkFilter(event, 'facebook', 'referrer')"> 
                        </div>

                        <div>
                            <label class="d-block text-center">YT</label>
                            <input id="check_yt" class="check" type="checkbox"  style="width:42px; height:35px;" onchange="checkFilter(event, 'youtube', 'referrer')"> 
                        </div>

                        <div>
                            <label class="d-block text-center">Go</label>
                            <input id="check_g" class="check" type="checkbox"  style="width:42px; height:35px;" onchange="checkFilter(event, 'google', 'referrer')"> 
                        </div>

                        <div>
                            <label class="d-block text-center">SIB </label>
                            <input id="check_sib" class="check" type="checkbox"  style="width:42px; height:35px;" onchange="checkFilter(event, 'sibrdzne.ge', 'referrer')"> 
                        </div>

                    </div>

                    <div class="col-12 mb-5 search_div">
                        <label>User Agent</label>
                        <input type="text" class="form-control datatable-filter" @if(isset($_GET['user_agent'])) value="{{$_GET['user_agent']}}" @endif data-live-search="true" data-filter="user_agent_id" placeholder="{{ $filterLabel }}" onchange="DataTableHelper.updateFilter(this, 'string')">
                    </div>
                </div>


            </div>
            <div class="row">
                <div class="col-lg-12  mt-3 mb-3" >
                    <a class="btn btn-secondary" href="{{ url()->current() }}">
                        <span><i class="la la-close"></i><span>Reset</span></span>
                    </a>
                </div>
            </div>
            <div class="m-separator m-separator--md m-separator--dashed"></div>
        </div>
    </div>
</div>