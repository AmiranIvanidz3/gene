<?php

namespace App\Http\Controllers;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\ModalNew;
use Illuminate\Support\Str;
use App\Models\UserSeenNews;
use App\Helpers\ExceptionHelper;
use App\Exceptions\ErrorException;
use App\Exceptions\SuccessException;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddBookRequest;
use App\Http\Requests\ModalNewRequest;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpFoundation\Request;

class ModalNewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth', 'password']);
    }

    public $title = 'modal-news';
    public $parent_menu = 'Settings';


    /**
     * Display a listing of the resource.
     */

    public function index()
    {

        // if(!Auth::user()->can('book:view')){
        //     abort(403, 'Forbidden!');
        // }

        $items = ModalNew::get();

        $menu[$this->parent_menu][$this->title] = true;

        return view(strtolower($this->title).'.view')
            ->with('menu', $menu) 
            ->with('page_title',ucwords(str_replace("-", " ", $this->parent_menu)))
            ->with('items', $items);

    }

    public function logNewsIndex()
    {

        // if(!Auth::user()->can('book:view')){
        //     abort(403, 'Forbidden!');
        // }
        $title = 'log-news';
        $items = UserSeenNews::get();

        $users = User::latest()->get();
        $news = ModalNew::latest()->get();

        $menu['logs'][$title] = true;

        return view(strtolower($title).'.view')
            ->with('menu', $menu) 
            ->with('users', $users) 
            ->with('news', $news) 
            ->with('page_title',ucwords(str_replace("-", " ", $this->parent_menu)))
            ->with('items', $items);

    }

    public function modalNewList(Request $request)
    {

        // if(!Auth::user()->can('book:view')){
        //     abort(403, 'Forbidden!');
        // }

        $query = ModalNew::latest();

        if($request->active_filter){
            $query->where('active', $request->active_filter);
        }

        return DataTables::of($query->get())->toJson();
    }

    public function logNewsList(Request $request)
    {

        // if(!Auth::user()->can('book:view')){
        //     abort(403, 'Forbidden!');
        // }
        $query = UserSeenNews::with('user', 'new')->latest();

        if($request->user_filter){
            $query->where('user_id', $request->user_filter);
        }
        
        if($request->new_filter){
            $query->where('news_id', $request->new_filter);
        }
        
        if($request->ip_filter){
            $query->where('ip','LIKE', '%'.$request->ip_filter.'%');
        }
        
        if($request->cookie_filter){
            $query->where('cookie','LIKE', '%'.$request->cookie_filter.'%');
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

        // if(!Auth::user()->can('book:add')){
        //     abort(403, 'Forbidden!');
        // }

        $menu[$this->parent_menu][$this->title] = true;

        return view(strtolower($this->title).'.add_edit')
            ->with('menu', $menu) 
            ->with('page_title', ucwords(str_replace("-", " ", $this->parent_menu)))
            ->with('action', 'add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModalNewRequest $request)
    {

        // if(!Auth::user()->can('book:add')){
        //     abort(403, 'Forbidden!');
        // }

        $item = new ModalNew();
        $item->title = $request->title;
        $item->description = $request->description;
        $item->from = $request->from;
        $item->to = $request->to;
        $item->active = $request->active;
        $item->cookie = Str::random(8);
        $item->external = $request->external ?? 0;
        $item->save();

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

        // if(!Auth::user()->can('book:update')){
        //     abort(403, 'Forbidden!');
        // }

        $item = ModalNew::find($id);
        
        $menu[$this->parent_menu][$this->title] = true;

        return view(strtolower($this->title).'.add_edit')
            ->with('action', 'edit')
            ->with('page_title',ucwords(str_replace("-", " ", $this->parent_menu))) 
            ->with('menu', $menu) 
            ->with('item', $item);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModalNewRequest $request, string $id)
    {

        // if(!Auth::user()->can('book:update')){
        //     abort(403, 'Forbidden!');
        // }

        $item = ModalNew::find($id);
        $item->title = $request->title;
        $item->description = $request->description;
        $item->from = $request->from;
        $item->to = $request->to;
        $item->active = $request->active;
        $item->external = $request->external;
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
        
        try
        {
            $item = ModalNew::find($id);
            $item->delete();
            throw new SuccessException;
        }
        catch(Exception $e){ return ExceptionHelper::toResponse($e); }
    }

    public function changeNewModalStatus(request $request){
        $item = ModalNew::find($request->id);
        $item->active = $request->active == 1 ? 0 : 1;
        $item->save();

        return response()->json([
            'success' => true,
      ]);
    }

    public function getNews(request $request){

        $currentDate = Carbon::now()->toDateString();

        $news_ids = UserSeenNews::where('cookie', $request->cookie)->pluck('news_id')->toArray();

        $news = ModalNew::with('userSeen')
        ->whereNotIn('id', $news_ids)
        ->where('active', 1)
        ->where('external', $request->external)
        ->orderBy('id', 'desc')
        ->whereDate('from', '<=', $currentDate)
        ->whereDate('to', '>=', $currentDate)
        ->orderBy('id', 'desc')
        ->first();

        $next = ModalNew::with('userSeen')
        ->whereNotIn('id', $news_ids)
        ->where('active', 1)
        ->orderBy('id', 'desc')
        ->whereDate('from', '<=', $currentDate)
        ->whereDate('to', '>=', $currentDate)
        ->skip(1) // Skip the first record
        ->first();
        

        return response()->json([
            'news' => $news,
            'next' => $next,
            'success' => true,
      ]);
    }

    public function userSeenNews(request $request){

        $item = new UserSeenNews();
        $item->news_id = $request->news_id;
        $item->user_id = Auth::user()->id ?? null;
        $item->ip = $request->ip();
        $item->cookie = $request->cookie;
        $item->save();

        return response()->json([
            'success' => true,
      ]);
    }
}
