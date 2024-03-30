<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Reel;
use App\Models\User;
use App\Models\Video;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Helpers\ExceptionHelper;
use App\Exceptions\ErrorException;
use App\Exceptions\SuccessException;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CommentController extends Controller
{
    public $title = 'comments';
    public $parent_menu = 'dashboard';
    public $breadcrumb_icon = 'fa fa-layer-group';
 

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
        if(!Auth::user()->can('comment:view')){
            abort(403, 'Forbidden!');
        }
        
        $menu[$this->parent_menu][$this->title] = true;

    

        

        return view($this->title.'.view')
            ->with('menu', $menu) 
            ->with('page_title',ucwords(str_replace("-", " ", $this->parent_menu)))
            ->with('breadcrumbs', [
                ['title' =>  ucwords(str_replace("-", " ", $this->title)), 'url' => adminUrl($this->title)]
            ])
            ->with('breadcrumb_icon', $this->breadcrumb_icon)
            ->with('create_title', ucfirst(rtrim($this->title,'s')));
            
    }
    
    public function commentList(Request $request){
        if(Auth::user()->hasRole('Author')){

            $video_ids = Video::where('author_id', Auth::user()->author_id)->pluck('id')->toArray();

            $reel_ids = Reel::whereIn('video_id', $video_ids)->pluck('id')->toArray();

            $reel_comments = Comment::where('model', 'Reel')->whereIn('model_id', $reel_ids)->pluck('id')->toArray();

            $video_comments = Comment::where('model', 'Video')->whereIn('model_id', $video_ids)->pluck('id')->toArray();

            $comment_ids = array_merge($reel_comments, $video_comments);

            $query = Comment::with('user', 'seenComment')->whereIn('id', $comment_ids);

        } else if(Auth::user()->hasRole('Playlist')){

            $user_id = Auth::user()->id;
            $playlist_ids = User::find($user_id)->userPlaylists()->pluck('playlist_id')->toArray();
            $video_ids = Video::whereIn('playlist_id', $playlist_ids)->pluck('id')->toArray();
            $reel_ids = Reel::whereIn('video_id', $video_ids)->pluck('id')->toArray();

            $playlist_comments = Comment::where('model', 'Playlist')->whereIn('model_id', $playlist_ids)->pluck('id')->toArray();
            $reel_comments = Comment::where('model', 'Reel')->whereIn('model_id', $reel_ids)->pluck('id')->toArray();
            $video_comments = Comment::where('model', 'Video')->whereIn('model_id', $video_ids)->pluck('id')->toArray();

            $comment_ids = array_merge($reel_comments, $video_comments, $playlist_comments);
            $query = Comment::with('user', 'seenComment')->whereIn('id', $comment_ids);
            
        } else {
       
            $query = Comment::with('user', 'seenComment')
            ->orderBy('id', 'desc');
            

        }

    return DataTables::of($query->get())
        ->addColumn('user_roles', function ($comment) {
            return $comment->user->getRoleNames()->implode(', ');
        })
        ->toJson();
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function setSeen(Request $request){

        $item = Comment::find($request->id); 

        $item->seenComment()->attach(Auth::user()->id);
 
 
         return response()->json([
             'success' => true,
       
         ]);

     }

}
