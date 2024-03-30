<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Author;
use App\Models\Channel;
use App\Models\Playlist;
use App\Helpers\UserHelper;
use App\Traits\ReorderTrait;
use Illuminate\Http\Request;
use App\Helpers\ExceptionHelper;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Exceptions\SuccessException;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\EditUserRequest;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;



class UserController extends Controller
{
    public $title = 'users';
    public $title_kebab = 'user';
    public $parent_menu = 'settings';
    public $breadcrumb_icon = 'flaticon-cogwheel-2';

    use ReorderTrait;

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

        if(!Auth::user()->can(strtolower($this->title_kebab).':view'))
        {
            abort(403, 'Unauthorized action !');
        } 

        $users = User::orderBy('order_priority', 'DESC')->get();

        $roles = Role::orderBy('name', 'DESC')->get();
        
        $menu['Settings']['Users'] = true;

        return view('users.view')
            ->with('menu', $menu) 
            ->with('roles', $roles) 
            ->with('page_title',ucwords(str_replace("-", " ", $this->parent_menu)))
            ->with('breadcrumbs', [
                ['title' =>  ucwords(str_replace("-", " ", $this->title)), 'url' => adminUrl($this->title)]
            ])
            ->with('users', $users)
            ->with('breadcrumb_icon', $this->breadcrumb_icon);
    }

    public function usersList(Request $request)
    {
        if(!Auth::user()->can(strtolower($this->title_kebab).':view'))
        {
            abort(403, 'Unauthorized action !');
        } 

        $query = User::select(
            'id',
            'name',
            'last_name',
            'email',
            'active',
            'reset',
            'created_at')->with('roles');

        if ($request->has('role_filter') && $request->role_filter != 0) {

            $user_ids = DB::table('model_has_roles')->where('model_type', 'App\Models\User')->where('role_id', $request->role_filter)->pluck('model_id')->toArray();

            $query->whereIn('id', $user_ids);
        }

        return DataTables::of($query)->addColumn('roles', function($user){
            if (count($user->roles) > 0) {
                $roleNames = [];
                foreach ($user->roles as $role) {
                    $roleNames[] = $role->name;
                }
                return implode(', ', $roleNames);
            } else {
                return "Without role";
            }
        })->toJson();

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $roles = Role::orderBy('name', 'ASC')->get();

        $permissions = Permission::orderBy('name', 'ASC')->get();

        $role_user = Role::find(3);

        $authors = Author::with('user')
        ->doesntHave('user')
        ->get();

        $playlists = Playlist::latest()
        ->get();

        $channels = Channel::latest()
        ->get();
      
    
 

        $menu['Settings']['Users'] = true;

        return view('users.add_edit')
            ->with('menu', $menu) 
            ->with('role_user', $role_user)
            ->with('page_title', ucwords(str_replace("-", " ", $this->parent_menu)))
            ->with('breadcrumbs', [
                ['title' =>  ucwords(str_replace("-", " ", $this->title)), 'url' => adminUrl($this->title)],
                ['title' => env('CREATE_NEW')]
             ])
            ->with('action', 'add')
            ->with('roles', $roles)
            ->with('permissions', $permissions)
            ->with('authors', $authors)
            ->with('playlists', $playlists)
            ->with('channels', $channels);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddUserRequest $request)
    {
        if(!Auth::user()->can(strtolower($this->title_kebab).':add'))
        {
            abort(403, 'Unauthorized action !');
        }



        try
        {
            $password = UserHelper::generateRandomPassword();
            $info = [
                'email' => $request->input('email'),
                'password' => $password,
            ];
           

            $user = UserHelper::store(
                $request->input('name'),
                $request->input('last_name'),
                $request->input('email'),
                $request->input('password'),
                true,
                $request->input('active'),
                $request->input('channel_id')
            );


            if(isset($request->playlists)){
                $sync_data = [];
                foreach($request->playlists as $playlist){
                    $sync_data[$playlist] = [
                        'user_id' => $user->id,
                        'playlist_id' => $playlist,
                    ];
                }
                $user->userPlaylists()->sync($sync_data);
            }            
               
                $role = Role::find($request->role_id);
                $user->syncRoles($role);

                return redirect()->route('users.index');
        }
        catch(Exception $e)
        {
            throw new ErrorException($e->getMessage());
        }
        throw new SuccessException;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        $menu['Settings']['Users'] = true;

        return view('users.show')
            ->with('user', $user)
            ->with('menu', $menu) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profile = request()->query('profile');

        $user_id = auth()->user()->id;

        $authors = Author::latest()->get();

        $playlists = Playlist::latest()->get();

        $channels = Channel::get();

        $user_playlist_ids = DB::table('user_has_playlists')
        ->where('user_id', $id)
        ->pluck('playlist_id')
        ->toArray();        

    
        
        if($profile){
            if($user_id != $id){
                abort(403, 'Unauthorized action !');
            }
        }else{
            if(!Auth::user()->can(strtolower($this->title_kebab).':update'))
            {
                abort(403, 'Unauthorized action !');
            } 
           
        }

        $user = User::with('playlists')->find($id);
        
        $roles = Role::orderBy('name', 'ASC')->get();
        $permissions = Permission::orderBy('name', 'ASC')->get();

        $menu['Settings']['Users'] = true;

        return view('users.add_edit')
            ->with('menu', $menu) 
            ->with('page_title', 'Users')
            ->with('breadcrumbs', [
                ['title' =>  ucwords(str_replace("-", " ", $this->title)), 'url' => adminUrl($this->title)],
                ['title' => "Edit"]
             ])
            ->with('user', $user)
            ->with('action', 'edit')
            ->with('roles', $roles)
            ->with('permissions', $permissions)
            ->with('authors', $authors)
            ->with('playlists', $playlists)
            ->with('user_playlist_ids', $user_playlist_ids)
            ->with('breadcrumb_icon', $this->breadcrumb_icon)
            ->with('channels', $channels);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditUserRequest $request, $id)
    { 
        $profile = request()->query('profile');

        $user_id = auth()->user()->id;

        if($profile){
            if($user_id != $id){
                abort(403, 'Unauthorized action !');
            }
        }else{
            if(!Auth::user()->can(strtolower($this->title_kebab).':update'))
            {
                abort(403, 'Unauthorized action !');
            } 
           
        }
        
        try
        {
            $users = User::find($id);
            $password = $request->input('password') ? $request->input('password') : null;

            if($id == $user_id){
                $reset = 0;
            }else{
                $reset = intval($request->reset);
            }

            $user = UserHelper::Update(
                $users->id,
                $request->input('name'),
                $request->input('last_name'),
                $request->input('email'),
                $password,
                $reset,
                $request->input('active'),
                $request->input('channel_id')
              
                
            );

            if(isset($request->playlists)){
                $item = User::find($id);
                $item->userPlaylists()->sync($request->playlists);
            }            

            $role = Role::find($request->role_id);
            $user->syncRoles($role);
            
            return redirect()->route('users.index');
        }
        catch(Exception $e)
        {
            throw new ErrorException($e->getMessage());
        }
        throw new SuccessException;

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
            $item = User::find($id);
            $item->delete();
            throw new SuccessException;
        }
        catch(Exception $e){ return ExceptionHelper::toResponse($e); }
    }

    public function callReorderPiority(\App\Models\User $user){
        return $this->reorderPriority($user, 'order_priority', 'users');
    }

    public function updateUser($table, $column_id, $selected_id)
    {

        // 

        DB::table($table)
            ->where('id', $column_id)
            ->update(['user_id' => $selected_id]);


        $res = [];
        $res['success'] = true;
        $res['data'] = [
            "column_id" => $column_id,
            "selected_user_id"=>$selected_id,
        ];

        header('Content-type: application/json');


        return json_encode($res);
        // 
    }

}

