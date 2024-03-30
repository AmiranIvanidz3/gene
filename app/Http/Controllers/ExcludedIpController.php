<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;
use Exception;
use Carbon\Carbon;
use App\Models\IpRequest;
use App\Models\ExcludedIp;
use App\Models\LogVisitor;
use Illuminate\Http\Request;
use App\Helpers\ExceptionHelper;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\DB;
use App\Exceptions\SuccessException;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ExcludedIpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $title = 'excluded-ips';
    public $parent_menu = 'ip-logs';
    public $breadcrumb_icon = 'flaticon-search';

    public function __construct()
    {
        $this->middleware(['auth', 'password']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        if(!Auth::user()->can('log:view')){
            abort(403, 'Forbidden!');
        }


        $items = ExcludedIp::orderBy('id', 'DESC')->get();


        $menu[$this->parent_menu][$this->title] = true;


        return view($this->title.'.view')
            ->with('menu', $menu) 
            ->with('page_title',ucwords(str_replace("-", " ", $this->parent_menu)))
            ->with('breadcrumbs', [
                ['title' =>  ucwords(str_replace("-", " ", str_ireplace("ip", "IP", $this->title))), 'url' => adminUrl($this->title)]
            ])
            ->with('items', $items)
            ->with('create_title', ucfirst(rtrim($this->title,'s')))
            ->with('breadcrumb_icon', $this->breadcrumb_icon);
    }

    public function ipRequestIndex()
    {
        $title = 'excluded-ip-requests';

        if(!Auth::user()->can('log:view')){
            abort(403, 'Forbidden!');
        }

        $items = ExcludedIp::orderBy('id', 'DESC')->get();

        $menu[$this->parent_menu][$title] = true;

        return view($title.'.view')
            ->with('menu', $menu) 
            ->with('page_title',ucwords(str_replace("-", " ", str_ireplace("ip", "IP", $this->parent_menu))))
            ->with('breadcrumbs', [
                ['title' =>  ucwords(str_replace("-", " ", str_ireplace("ip", "IP", $title))), 'url' => adminUrl($title)]
            ])
            ->with('items', $items)
            ->with('create_title', ucfirst(rtrim($title,'s')))
            ->with('breadcrumb_icon', $this->breadcrumb_icon);
    }


    public function excludedIpList(Request $request)
    {

        // if(!Auth::user()->can('log:view')){
        //     abort(403, 'Forbidden!');
        // }

        $query = ExcludedIp::get();

        return DataTables::of($query)->toJson();
    }

    public function ipRequestList(Request $request)
    {

        $query = IpRequest::with('ip');

        if($request->from_date_filter){
            $date = Carbon::parse($request->from_date_filter)->format('Y-m-d');
            $query->whereDate("date", ">=", $date);
        }
        
        if($request->to_date_filter){
            $date = Carbon::parse($request->to_date_filter)->format('Y-m-d');
            $query->whereDate("date", "<=", $date);
        }

        if($request->ip_id){

            $ip_id = ExcludedIp::where('ip', $request->ip_id)->pluck('id')->first();

            $query->where("ip_id", $ip_id);
        }

        return DataTables::of($query->get())->toJson();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if(!Auth::user()->can('log:view')){
            abort(403, 'Forbidden!');
        }

        $menu[$this->parent_menu][$this->title] = true;


        return view($this->title.'.add_edit')
            ->with('menu', $menu) 
            ->with('page_title', ucwords(str_replace("-", " ", $this->parent_menu)))
            ->with('breadcrumbs', [
                ['title' =>  ucwords(str_replace("-", " ", str_ireplace("ip", "IP", $this->title))), 'url' => adminUrl($this->title)],
                ['title' => env('CREATE_NEW')]
             ])
            ->with('action', 'add')
            ->with('breadcrumb_icon', $this->breadcrumb_icon);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(!Auth::user()->can('log:view')){
            abort(403, 'Forbidden!');
        }
        
        try
        {
            $item = new ExcludedIp();
            $item->ip = $request->ip;
            $item->comment = $request->comment;
            $item->save();

        }
        catch(Exception $e)
        {
            throw new ErrorException($e->getMessage());
        }
        return redirect('/'.env('ADMIN_URL').'/'.$this->title);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        if(!Auth::user()->can('log:view')){
            abort(403, 'Forbidden!');
        }


        $menu[$this->parent_menu][$this->title] = true;

        $item = ExcludedIp::find($id);

        return view($this->title.'.add_edit')
            ->with('menu', $menu) 
            ->with('page_title',ucwords(str_replace("-", " ", $this->parent_menu))) 
            ->with('breadcrumbs', [
                ['title' =>  ucwords(str_replace("-", " ", str_ireplace("ip", "IP", $this->title))), 'url' => adminUrl($this->title)],
                ['title' => "Edit"]
             ])
             ->with('item', $item)
            ->with('action', 'edit')
            ->with('breadcrumb_icon', $this->breadcrumb_icon);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if(!Auth::user()->can('log:view')){
            abort(403, 'Forbidden!');
        }

        $item = ExcludedIp::find($id);
        $item->ip = $request->ip;
        $item->comment = $request->comment;
        $item->save();


        return redirect('/'.env('ADMIN_URL').'/'.$this->title);
       
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if(!Auth::user()->can('project:update')){
        //     abort(403, 'Forbidden!');
        // }

        try
        {
            $item = ExcludedIp::find($id);
            $item->delete();
          
            throw new SuccessException;
        }
        catch(Exception $e){ return ExceptionHelper::toResponse($e); }
    }

    function excludeIp(Request $request){

        $visitor_ip = $request->ip;

        $grouped_logs = LogVisitor::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
        ->where('ip', $visitor_ip)
        ->groupBy('date')
        ->orderBy('date', 'DESC')
        ->get(); 

        $ip = ExcludedIp::firstOrCreate(
            ['ip' =>  $visitor_ip],
            ['comment' => $request->message] 
        );

        $ip_id = $ip->id;

        foreach($grouped_logs as $grouped_log){
            
            $count = IpRequest::where('ip_id', $ip_id)
            ->where('date', $grouped_log->date)
            ->pluck('count')
            ->first();

            IpRequest::updateOrInsert(
                ['date' => $grouped_log->date, 'ip_id' => $ip_id], 
                ['count' => $grouped_log->count + $count, 'created_at' => now()->setTimezone('Asia/Tbilisi')]
            );
        }

        $grouped_logs = LogVisitor::where('ip', 'like', "$visitor_ip%")
            ->delete();

        
    }

}
