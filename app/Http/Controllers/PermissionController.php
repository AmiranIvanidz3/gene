<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use App\Helpers\ExceptionHelper;
use App\Exceptions\ErrorException;
use App\Exceptions\SuccessException;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{


    public function __construct()
    {
        $this->middleware(['auth', 'password']);
    }

    public $title = 'permissions';
    public $parent_menu = 'settings';
    public $breadcrumb_icon = 'flaticon-cogwheel-2';


    /**
     * Display a listing of the resource.
     */

    public function index()
    {

        if(!Auth::user()->can('permission:view')){
            abort(403, 'Forbidden!');
        }

        $items = Permission::get();

        $menu['Settings']['Permission'] = true;

        return view(strtolower($this->title).'.view')
            ->with('menu', $menu) 
            ->with('page_title',ucwords(str_replace("-", " ", $this->parent_menu)))
            ->with('breadcrumbs', [
                ['title' =>  ucwords(str_replace("-", " ", $this->title)), 'url' => adminUrl($this->title)]
            ])
            ->with('items', $items)
            ->with('breadcrumb_icon', $this->breadcrumb_icon);

    }

    public function permissionList(Request $request)
    {

        if(!Auth::user()->can('permission:view')){
            abort(403, 'Forbidden!');
        }

        $query = Permission::get();

        return DataTables::of($query)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if(!Auth::user()->can('permission:add')){
            abort(403, 'Forbidden!');
        }

        $menu['Settings']['Permission'] = true;

       
        return view(strtolower($this->title).'.add_edit')
            ->with('menu', $menu) 
            ->with('page_title', ucwords(str_replace("-", " ", $this->parent_menu)))
            ->with('breadcrumbs', [
                ['title' =>  ucwords(str_replace("-", " ", $this->title)), 'url' => adminUrl($this->title)],
                ['title' => env('CREATE_NEW')]
             ])
            ->with('action', 'add')
            ->with('breadcrumb_icon', $this->breadcrumb_icon);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if(!Auth::user()->can('permission:add')){
            abort(403, 'Forbidden!');
        }

        $item = new Permission();
        $item->name = $request->name;
        $item->save();

        return redirect('/'.env('ADMIN_URL').'/'.$this->title);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        if(!Auth::user()->can('permission:update')){
            abort(403, 'Forbidden!');
        }

        $item = Permission::find($id);
        
        $menu['Settings']['Permission'] = true;


        return view(strtolower($this->title).'.add_edit')
            ->with('action', 'edit')
            ->with('page_title',ucwords(str_replace("-", " ", $this->parent_menu))) 
            ->with('breadcrumbs', [
                ['title' =>  ucwords(str_replace("-", " ", $this->title)), 'url' => adminUrl($this->title)],
                ['title' => "Edit"]
             ])
            ->with('menu', $menu) 
            ->with('item', $item)
            ->with('breadcrumb_icon', $this->breadcrumb_icon);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        if(!Auth::user()->can('permission:update')){
            abort(403, 'Forbidden!');
        }

        $permission = Permission::find($id);
        $permission->name = $request->name;


        $permission->save();

        return redirect('/'.env('ADMIN_URL').'/'.$this->title);

    }

    /**
     * Remove the specified resource from storage.
     */
  public function destroy($id)
    {
        
        try
        {
            $item = Permission::find($id);
            $item->delete();
            throw new SuccessException;
        }
        catch(Exception $e){ return ExceptionHelper::toResponse($e); }
    }
}
