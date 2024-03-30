<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Log;
use App\Models\Reel;
use App\Models\User;
use App\Models\Parameter;
use App\Models\LogVisitor;
use App\Models\UserAction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Helpers\ExceptionHelper;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\DB;
use App\Exceptions\SuccessException;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;




class LogController extends Controller
{
    
    public $title = 'logs';
    public $parent_menu = 'logs';
    public $group_title = 'group-log-reels';
    public $group_title_ip = 'group-log-ip';
    public $group_title_session = 'group-log-session';
    public $group_title_ua = 'group-log-ua';
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

        $items = Log::orderBy('id', 'DESC')->get();

        $users = User::orderBy('name', 'ASC')->get();

        $actions = UserAction::get();

        $menu[$this->parent_menu][$this->title] = true;


        return view($this->title.'.view')
            ->with('menu', $menu) 
            ->with('actions', $actions) 
            ->with('users', $users) 
            ->with('page_title', ucwords(str_replace("-", " ", $this->title)))
            ->with('breadcrumbs', [['title' => ucwords(str_replace("-", " ", 'actions')), 'url' => adminUrl($this->title)]])
            ->with('items', $items)
            ->with('create_title', ucfirst(rtrim($this->title,'s')))
            ->with('breadcrumb_icon', $this->breadcrumb_icon);
    }

    public function logList(Request $request)
    {

        if(!Auth::user()->can('log:view')){
            abort(403, 'Forbidden!');
        }

        $query = Log::with('user', 'action');

        if ($request->has('user_filter') && $request->user_filter != 0) {
            $query->where('user_id', $request->user_filter);
        }
        if ($request->has('action_filter') && $request->action_filter != 0) {
            $query->where('action_id', $request->action_filter);
        }

        return DataTables::of($query->get())->toJson();

    }

    public static function store($action, $data = NULL)
    {

        $actions = config('actions');

        $json_data = $data ? json_encode($data) : $data;
        $log = new Log();
        $log->user_id = Auth::user()->id;
        $log->action_id = $actions[$action];
        $log->datetime = now();
        $log->ip = request()->ip();
        $log->data = $json_data;
        $log->save();
    }

    public function groupLogIndex($group)
    {

        // if(!Auth::user()->can('platform:view')){
        //     abort(403, 'Forbidden!');
        // }


        if($group == 'reels'){
            $file_name_start = 'reels';
            $title = "group-reels";
        }else if($group== 'date'){
            $file_name_start = 'date';
            $title = "group-date-reels";
        }

        $menu['log'][$this->title] = true;
  
        return view($this->group_title.'.'.$file_name_start)
            ->with('menu', $menu)
            ->with('page_title',ucwords(str_replace("-", " ", $this->parent_menu)))
            ->with('breadcrumbs', [
	            ['title' =>  ucwords(str_replace("-", " ", $title)), 'url' => adminUrl($this->title)]
	        ])
            ->with('breadcrumb_icon', $this->breadcrumb_icon)
            ->with('create_title',ucfirst(rtrim($this->group_title,'s')))
            ->with('breadcrumb_icon', $this->breadcrumb_icon);
           
    }

    public function groupLogIpIndex($group)
    {

        if($group == 'ip'){
            $file_name_start = 'ip';
            $group = "IPs";
        }else if($group == 'date'){
            $file_name_start = 'date';
            $group .= ' IPs';
        }

        $menu['log'][$this->title] = true;

        // $group == 'date' ? $group = 'date IP' : "";
        // dd(strpos("ip", $group));

  
        return view($this->group_title_ip.'.'.$file_name_start)
            ->with('menu', $menu)
            ->with('page_title',ucwords(str_replace("-", " ", $this->parent_menu)))
            ->with('breadcrumbs', [
	            ['title' =>  ucwords(str_replace("-", " ", 'group-'.$group)), 'url' => adminUrl($this->title)]
	        ])
            ->with('breadcrumb_icon', $this->breadcrumb_icon)
            ->with('create_title',ucfirst(rtrim($this->group_title,'s')))
            ->with('breadcrumb_icon', $this->breadcrumb_icon);
           
    }

    public function groupLogUAIndex($group)
    {

        if($group == 'ua'){
            $file_name_start = 'ua';
            $group = "User Agents";
        }else if($group == 'date'){
            $file_name_start = 'date';
            $group .= ' User Agents';
        }

        $menu['log'][$this->title] = true;

        return view($this->group_title_ua.'.'.$file_name_start)
            ->with('menu', $menu)
            ->with('page_title',ucwords(str_replace("-", " ", $this->parent_menu)))
            ->with('breadcrumbs', [
	            ['title' =>  ucwords(str_replace("-", " ", 'group-'.$group)), 'url' => adminUrl($this->title)]
	        ])
            ->with('breadcrumb_icon', $this->breadcrumb_icon)
            ->with('create_title',ucfirst(rtrim($this->group_title,'s')))
            ->with('breadcrumb_icon', $this->breadcrumb_icon);
           
    }

    public function grouplogMentionList(Request $request, $group)
    {
        
        $query = LogVisitor::query();
            
        if($request->from_date_filter){
            $date = Carbon::parse($request->from_date_filter)->format('Y-m-d');
            $query->whereDate("log_visitors.created_at", ">=", $date);
        }


        if($request->to_date_filter){
            $date = Carbon::parse($request->to_date_filter)->format('Y-m-d');
            $query->whereDate("log_visitors.created_at", "<=", $date);
        }

        if ($group == '2') {

            $query -> select
            (
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(DISTINCT ip) as unique_hosts'),
                DB::raw('COUNT(DISTINCT ip,  reel_id) as cnt'),
                DB::raw('COUNT(DISTINCT reel_id) as unique_reels_count'),
                DB::raw("(SELECT COUNT(*) FROM log_visitors WHERE (DATE(created_at) = date) AND reel_id IS NOT NULL) as total_cnt")
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->where('reel_id', '!=', 'null')
            ->orderBy('date', 'DESC');

        } elseif ($group == '1') {

            $query->leftJoin('reels', 'reels.id', '=', 'log_visitors.reel_id')
            ->select(
                'reel_id', 
                'reels.title',
                DB::raw('DATE(log_visitors.created_at) date'), 
                DB::raw('COUNT(log_visitors.id) as cnt'),
                DB::raw('COUNT(DISTINCT ip) total_cnt')
            )
            ->where('reel_id', '!=', 'null')
            ->groupBy('reel_id')
            ->orderBy('cnt', 'DESC');
    
        }

        $filters = [
            "session_id",
        ];
    
        foreach ($filters as $value) {
            if ($request->has($value) && $request->$value != null) { 
                if($value == 'session_id'){
                    $query->where("session_id", "LIKE", "%{$request->input($value)}%");
                }else{
                    $query->where($value, $request->input($value));
                }
            }
        }
        
        if($request->ip_id){
            $query->where("ip", "LIKE", "%{$request->ip_id}%");
        }

        if($request->query_string_id){

            $query->where("query_string", "LIKE", "%{$request->query_string_id}%");
        }

        if($request->referrer_id){
            $query->where("referrer", "LIKE", "%{$request->referrer_id}%");
        }

        if($request->user_agent_id){
            $query->where("user_agent", "LIKE", "%{$request->user_agent_id}%");
        }


        return DataTables::of($query->get())->toJson();
    }

    public function grouplogipList(Request $request, $group)
    {
        $oneMonthAgo = Carbon::now()->subMonth();

        $query = LogVisitor::query();

        if($request->from_date_filter){
            $date = Carbon::parse($request->from_date_filter)->format('Y-m-d');
            $query->whereDate("created_at", ">=", $date);
        }else{
            $query->where('created_at', '>', $oneMonthAgo);
        }
        
        if($request->to_date_filter){
            $date = Carbon::parse($request->to_date_filter)->format('Y-m-d');
            $query->whereDate("created_at", "<=", $date);
        }
    
    
        if ($group == '2') {
            
            $query->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(DISTINCT ip) as cnt'),
                DB::raw('COUNT(*) as total_cnt'),
                DB::raw('COUNT(DISTINCT session_id) as session_cnt')
            )
            ->groupBy('date')
            ->orderBy('date', 'DESC'); 

         
        } elseif ($group == '1') {

            $query->select(
                    'ip', 
                    DB::raw('count(*) as count'),
                    DB::raw('COUNT(DISTINCT session_id) as session_cnt')
                )
            ->groupBy('ip');

        }

        $filters = [
            "session_id",
        ];
    
        foreach ($filters as $value) {
            if ($request->has($value) && $request->$value != null) { 
                if($value == 'session_id'){
                    $query->where("session_id", "LIKE", "%{$request->input($value)}%");
                }else{
                    $query->where($value, $request->input($value));
                }
            }
        }
        
        if($request->ip_id){
            $query->where("ip", "LIKE", "%{$request->ip_id}%");
        }

        if($request->query_string_id){

            $query->where("query_string", "LIKE", "%{$request->query_string_id}%");
        }

        if($request->referrer_id){
            $query->where("referrer", "LIKE", "%{$request->referrer_id}%");
        }

        if($request->user_agent_id){
            $query->where("user_agent", "LIKE", "%{$request->user_agent_id}%");
        }

      
        return DataTables::of($query->get())->toJson();
    }
    
    public function grouplogUAList(Request $request, $group)
    {

        $oneMonthAgo = Carbon::now()->subMonth();

        $query = LogVisitor::query();

        if($request->from_date_filter){
            $date = Carbon::parse($request->from_date_filter)->format('Y-m-d');
            $query->whereDate("created_at", ">=", $date);
        }else{
            $query->where('created_at', '>', $oneMonthAgo);
        }
        
        if($request->to_date_filter){
            $date = Carbon::parse($request->to_date_filter)->format('Y-m-d');
            $query->whereDate("created_at", "<=", $date);
        }
    
    
        if ($group == '2') {
            
            $query->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(DISTINCT user_agent) as cnt'),
                DB::raw('COUNT(*) as total_cnt')
            )
            ->groupBy('date')
            ->orderBy('date', 'DESC'); 

         
        } elseif ($group == '1') {

            $query->select('user_agent', DB::raw('count(*) as count'))
            ->groupBy('user_agent');

        }

        $filters = [
            "session_id",
        ];
    
        foreach ($filters as $value) {
            if ($request->has($value) && $request->$value != null) { 
                if($value == 'session_id'){
                    $query->where("session_id", "LIKE", "%{$request->input($value)}%");
                }else{
                    $query->where($value, $request->input($value));
                }
            }
        }
        
        if($request->ip_id){
            $query->where("ip", "LIKE", "%{$request->ip_id}%");
        }

        if($request->query_string_id){

            $query->where("query_string", "LIKE", "%{$request->query_string_id}%");
        }

        if($request->referrer_id){
            $query->where("referrer", "LIKE", "%{$request->referrer_id}%");
        }

        if($request->user_agent_id){
            $query->where("user_agent", "LIKE", "%{$request->user_agent_id}%");
        }

      
        return DataTables::of($query->get())->toJson();
    }

    public function visitorIndex()
    {
        $url = 'log-visitors';
        $menu[$this->parent_menu]['visitors']= true;

        $referrer_letters_count = Parameter::getValue('referrer_letters_count');

        return view('log-visitors.view')
            ->with('menu', $menu)
            ->with('create_title',ucfirst(rtrim($this->title,'s')))
            ->with('page_title',ucwords(str_replace("-", " ", $this->title)))
            ->with('breadcrumbs', [
	            ['title' =>  ucwords(str_replace("-", " ", 'Visitors')), 'url' => adminUrl($url)]
	        ])
            ->with('create_title',ucfirst(rtrim($this->title,'s')))
            ->with('breadcrumb_icon', $this->breadcrumb_icon)
            ->with('referrer_letters_count', $referrer_letters_count);
           
    }


    public function logVisitorsList(Request $request)
    {
        $query = LogVisitor::with("author", "reel")->orderBy('created_at', 'desc');

        $previousUrl = url()->previous();
        $string = $previousUrl;
        parse_str(parse_url($string, PHP_URL_QUERY), $url);
        
        $filters = [
            "session_id",
        ];
    
        foreach ($filters as $value) {
            if ($request->has($value) && $request->$value != null) { 
                if($value == 'session_id'){
                    $query->where("session_id", "LIKE", "%{$request->input($value)}%");
                }else{
                    $query->where($value, $request->input($value));
                }
            }
        }
        
        if($request->ip_id){
            $query->where("ip", "LIKE", "%{$request->ip_id}%");
        }

        if($request->query_string_id){

            $query->where("query_string", "LIKE", "%{$request->query_string_id}%");
        }

        if($request->session_id){
            $query->where("session_id", "LIKE", "%{$request->session_id}%");
        }

        if($request->referrer_id){
            $query->where("referrer", "LIKE", "%{$request->referrer_id}%");
        }

        if($request->user_agent_id){
            $query->where("user_agent", "LIKE", "%{$request->user_agent_id}%");
        }

        if($request->from_date_filter){
            $date = Carbon::parse($request->from_date_filter)->format('Y-m-d');
            $query->whereDate("created_at", ">=", $date);
        }
        
        if($request->to_date_filter){
            $date = Carbon::parse($request->to_date_filter)->format('Y-m-d');
            $query->whereDate("created_at", "<=", $date);
        }

        return DataTables::of($query)->toJson();
    }


    public function grouplogstatistiIndex()
    {

        if(!Auth::user()->can('log:view')){
            abort(403, 'Forbidden!');
        }

        $menu[$this->parent_menu][$this->title] = true;

        return view('group-log-reels.statistic')
            ->with('menu', $menu) 
            ->with('page_title', ucwords(str_replace("-", " ", $this->title)))
            ->with('breadcrumbs', [['title' => ucwords(str_replace("-", " ", 'actions')), 'url' => adminUrl($this->title)]])
            ->with('create_title', ucfirst(rtrim($this->title,'s')))
            ->with('breadcrumb_icon', $this->breadcrumb_icon);
    }

    public function grouplogstatisticList(Request $request)
    {

        if(!Auth::user()->can('log:view')){
            abort(403, 'Forbidden!');
        }

        $previousUrl = url()->previous();
        $string = $previousUrl;
        parse_str(parse_url($string, PHP_URL_QUERY), $url);

        $query = LogVisitor::query();

        if($request->from_date_filter){
            $date = Carbon::parse($request->from_date_filter)->format('Y-m-d');
            $query->whereDate("log_visitors.created_at", ">=", $date);
        }

        if($request->to_date_filter){
            $date = Carbon::parse($request->to_date_filter)->format('Y-m-d');
            $query->whereDate("log_visitors.created_at", "<=", $date);
        }

        $query->leftJoin('reels', 'reels.id', '=', 'log_visitors.reel_id')
        ->select(
            DB::raw('DATE(log_visitors.created_at) as date'),
            'reels.id as reel_id',
            'reels.title',
            DB::raw('COUNT(log_visitors.id) as cnt'),
            DB::raw('COUNT(DISTINCT log_visitors.ip) as total_cnt')
        )
        
        ->where('reel_id', $url['reel'])
        ->groupBy('date', 'reels.id', 'reels.title') // Group by date, reel_id, and title
        ->orderBy('date', 'DESC'); // Order by created_at date in descending order

        return DataTables::of($query->get())->toJson();

    }

}