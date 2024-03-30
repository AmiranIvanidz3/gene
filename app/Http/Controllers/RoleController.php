<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\AddRoleRequest;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'password']);
    }
    public $title = 'roles';
    public $parent_menu = 'settings';
    public $breadcrumb_icon = 'flaticon-cogwheel-2';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::user()->can('role:view'))
        {
            abort(403, 'Unauthorized action !');
        }

        $roles = Role::orderBy('id', 'ASC')->get();

        $menu['Settings']['Roles'] = true;

        return view('roles.view')
            ->with('menu', $menu) 
            ->with('page_title',ucwords(str_replace("-", " ", $this->parent_menu)))
            ->with('breadcrumbs', [
                ['title' =>  ucwords(str_replace("-", " ", $this->title)), 'url' => adminUrl($this->title)]
            ])

            ->with('roles', $roles)
            ->with('breadcrumb_icon', $this->breadcrumb_icon);
    }

    public function roleList(Request $request)
    {
        $query = Role::select(
            'id',
           'name');
        return DataTables::of($query)->toJson();
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

        $menu['Settings']['Roles'] = true;

        return view('roles.add_edit')
            ->with('menu', $menu) 
            ->with('page_title', ucwords(str_replace("-", " ", $this->parent_menu)))
            ->with('breadcrumbs', [
                ['title' =>  ucwords(str_replace("-", " ", $this->title)), 'url' => adminUrl($this->title)],
                ['title' => env('CREATE_NEW')]
             ])

            ->with('action', 'add')
            ->with('roles', $roles)
            ->with('permissions', $permissions)
            ->with('breadcrumb_icon', $this->breadcrumb_icon);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddRoleRequest $request)
    {
        $role = new Role();
        $role->name = $request->name;
        $role->save();

        // Add role's permissions
        $permissions = $request->permissions ?? [];
        $role->syncPermissions($permissions);

        $roles = Role::orderBy('id', 'DESC')->get();

        $menu['Settings']['Roles'] = true;

        return view('roles.view')
            ->with('add_result', true)
            ->with('roles', $roles)
            ->with('menu', $menu) ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);

        // // Different ways to access role's permissions
        // $permissions = $role->permissions()->get();
        // $permissions = $role->getAllPermissions();
        // $permissions = $role->permissions;

        $permissions = Permission::orderBy('name', 'ASC')->get();

        $menu['Settings']['Roles'] = true;

        return view('roles.show')
            ->with('role', $role)
            ->with('menu', $menu) 
            ->with('permissions', $permissions);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);

        $roles = Role::orderBy('name', 'ASC')->get();

        $permissions = Permission::orderBy('name', 'ASC')->get();

        $menu['Settings']['Roles'] = true;

        return view('roles.add_edit')
            ->with('menu', $menu) 
            ->with('page_title',ucwords(str_replace("-", " ", $this->parent_menu))) 
            ->with('breadcrumbs', [
                ['title' =>  ucwords(str_replace("-", " ", $this->title)), 'url' => adminUrl($this->title)],
                ['title' => "Edit"]
             ])
            ->with('role', $role)
            ->with('roles', $roles)
            ->with('action', 'edit')
            ->with('permissions', $permissions)
            ->with('breadcrumb_icon', $this->breadcrumb_icon);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddRoleRequest $request, $id)
    {
        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();

        // Update role's permissions
        $permissions = $request->permissions ?? [];
        $role->syncPermissions($permissions);

        $roles = Role::orderBy('id', 'DESC')->get();

        $menu['Settings']['Roles'] = true;

        return view('roles.view')
            ->with('update_result', true)
            ->with('roles', $roles)
            ->with('menu', $menu) ;
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
        $item = Role::find($id);
        $item->delete();

        return response()->json(['message'=> 'Deleted Successfully!!!']);
    }

    /**
     * Return roles list.
     *
     * @return \Illuminate\Http\Response
     */
    public function rolePermissions($role_id)
    {
        // $permissions = Permission::orderBy('id', 'ASC')->where('role_id', )->get();

        // return [
        //     'success'=>true,
        //     'data'=>[
        //         'permissions'=>$permissions
        //     ],
        // ];

       
        $role_ids = explode(',', $role_id);

        $roles = Role::whereIn('id', $role_ids)->get();

        $permissions = [];
        
        foreach ($roles as $role) {
            $permissions = array_merge($permissions, $role->getPermissionNames()->toArray());
        }
        

        $permissions = array_values(array_unique($permissions));
        return json_encode($permissions);
    }
}
