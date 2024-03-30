<?php

namespace App\Http\Controllers;
use Exception;
use Carbon\Carbon;
use App\Models\ExcludedUserAgentRequests;
use App\Models\ExcludedUserAgents;
use App\Models\LogVisitor;
use Illuminate\Http\Request;
use App\Helpers\ExceptionHelper;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\DB;
use App\Exceptions\SuccessException;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ExcludedUserAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $title = 'excluded-user-agents';
    public $parent_menu = 'ua-logs';
    public $breadcrumb_icon = 'flaticon-search';

    public function __construct()
    {
        $this->middleware(['auth', 'password']);
    }
    
    public function index()
    {
       
        if(!Auth::user()->can('log:view')){
            abort(403, 'Forbidden!');
        }


        $items = ExcludedUserAgents::orderBy('id', 'DESC')->get();


        $menu[$this->parent_menu][$this->title] = true;


        return view($this->title.'.view')
            ->with('menu', $menu) 
            ->with('page_title',ucwords(str_replace("-", " ", $this->parent_menu)))
            ->with('breadcrumbs', [
                ['title' =>  ucwords(str_replace("-", " ", str_ireplace("user_agent", "User Agent", $this->title))), 'url' => adminUrl($this->title)]
            ])
            ->with('items', $items)
            ->with('create_title', ucfirst(rtrim($this->title,'s')))
            ->with('breadcrumb_icon', $this->breadcrumb_icon);
    }

    public function ExcludedUserAgentRequestsIndex()
    {
        $title = 'excluded-user-agent-requests';

        if(!Auth::user()->can('log:view')){
            abort(403, 'Forbidden!');
        }

        $items = ExcludedUserAgents::orderBy('id', 'DESC')->get();

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


    public function excludedUserAgentsList(Request $request)
    {

        // if(!Auth::user()->can('log:view')){
        //     abort(403, 'Forbidden!');
        // }

        $query = ExcludedUserAgents::get();

        return DataTables::of($query)->toJson();
    }

    public function ExcludedUserAgentRequestsList(Request $request)
    {

        $query = ExcludedUserAgentRequests::with('userAgent');

        if($request->from_date_filter){
            $date = Carbon::parse($request->from_date_filter)->format('Y-m-d');
            $query->whereDate("date", ">=", $date);
        }
        
        if($request->to_date_filter){
            $date = Carbon::parse($request->to_date_filter)->format('Y-m-d');
            $query->whereDate("date", "<=", $date);
        }

        if($request->user_agent_id){

            $user_agent = ExcludedUserAgents::where('user_agent', $request->user_agent_id)->pluck('id')->first();

            $query->where("user_agent_id", $user_agent);
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

        // if(!Auth::user()->can('log:add')){
        //     abort(403, 'Forbidden!');
        // }

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

        // if(!Auth::user()->can('log:add')){
        //     abort(403, 'Forbidden!');
        // }
        
        try
        {
            $item = new ExcludedUserAgents();
            $item->user_agent = $request->user_agent;
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

        // if(!Auth::user()->can('log:update')){
        //     abort(403, 'Forbidden!');
        // }



        $menu[$this->parent_menu][$this->title] = true;

        $item = ExcludedUserAgents::find($id);

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
   
        // if(!Auth::user()->can('log:update')){
        //     abort(403, 'Forbidden!');
        // }

        $item = ExcludedUserAgents::find($id);
        $item->user_agent = $request->user_agent;
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
            $item = ExcludedUserAgents::find($id);
            $item->delete();
          
            throw new SuccessException;
        }
        catch(Exception $e){ return ExceptionHelper::toResponse($e); }
    }

    function excludeUA(Request $request){

        $grouped_logs = LogVisitor::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
        ->where('user_agent', $request->user_agent)
        ->groupBy('date')
        ->orderBy('date', 'DESC')
        ->get(); 



        $user_agent = ExcludedUserAgents::firstOrCreate(
            ['user_agent' =>  $request->user_agent],
            ['comment' => $request->message] 
        );

        $user_agent_id = $user_agent->id;


        foreach($grouped_logs as $grouped_log){
            
            $count = ExcludedUserAgentRequests::where('user_agent_id', $user_agent_id)
            ->where('date', $grouped_log->date)
            ->pluck('count')
            ->first();


            ExcludedUserAgentRequests::updateOrInsert(
                ['date' => $grouped_log->date, 'user_agent_id' => $user_agent_id], 
                ['count' => $grouped_log->count + $count, 'created_at' => now()->setTimezone('Asia/Tbilisi')]
            );

        }

        $grouped_logs = LogVisitor::where('user_agent', $request->user_agent)->delete();

    }

}
