<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use App\Models\ProcedureType;
use App\Models\ProcedureGroup;
use App\Helpers\ExceptionHelper;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\DB;
use App\Exceptions\SuccessException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class ProcedureTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $title = 'procedure-types';
    public $parent_menu = 'administration';
    public $submenu = 'procedures';


    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('password');
    }


    public function index()
    {
       

        $menu[$this->parent_menu][$this->submenu][$this->title] = true;
        return view(strtolower($this->title).'.view')
            ->with('menu', $menu) 
            ->with('page_title',ucwords(str_replace("-", " ", $this->parent_menu)));
    }

    public function procedureTypeList(Request $request)
    {
        $query = ProcedureType::with('procedureGroup')->get();

        return DataTables::of($query)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu[$this->parent_menu][$this->submenu][$this->title] = true;   
             
        $procedure_groups  = ProcedureGroup::all();

        return view(strtolower($this->title).'.add_edit')
        ->with('action', 'add')
        ->with('procedure_groups', $procedure_groups)
        ->with('menu', $menu);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $item = new ProcedureType();
            $item->name = $request->name;
            $item->procedure_group_id = $request->procedure_group_id;
            $item->save();
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }

            return Redirect::route('procedure-types.index');
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
        $item = ProcedureType::find($id);
        
        $procedure_groups  = ProcedureGroup::all();

        $menu[$this->parent_menu][$this->submenu][$this->title] = true;
        return view(strtolower($this->title).'.add_edit')
            ->with('menu', $menu) 
            ->with('procedure_groups', $procedure_groups) 
            ->with('item', $item)
            ->with('action', 'edit');
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
        $item = ProcedureType::find($id);
        $item->name = $request->name;
        $item->procedure_group_id = $request->procedure_group_id;
        $item->save();

        return Redirect::route('procedure-types.index');
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
            $item = ProcedureType::find($id);

            $item->delete();
            throw new SuccessException;
        }
        catch(Exception $e){
             return ExceptionHelper::toResponse($e);
             }
    }
}
