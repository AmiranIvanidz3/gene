<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Procedure;
use Illuminate\Http\Request;
use App\Models\ProcedureDone;
use App\Helpers\ExceptionHelper;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\DB;
use App\Exceptions\SuccessException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class ProcedureDoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $title = 'procedures_done';
    public $parent_menu = 'resources';


    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('password');
    }


    public function index()
    {
       

        $menu[$this->parent_menu][$this->title] = true;

        return view(strtolower($this->title).'.view')
            ->with('menu', $menu) 
            ->with('page_title',ucwords(str_replace("-", " ", $this->parent_menu)));
    }

    public function donorList(Request $request)
    {
        $query = ProcedureDone::get();

        return DataTables::of($query)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $procedures = Procedure::all();
        $menu[$this->parent_menu][$this->title] = true;

        return view(strtolower($this->title).'.add_edit')
        ->with('procedures', $procedures)
        ->with('action', 'add')
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
            $item = new ProcedureDone();
            $item->visid_id = $request->name;
            $item->comment = $request->comment;
            $item->save();
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }

            return Redirect::route('procedures_done.index');
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
        $item = ProcedureDone::find($id);
        $procedures = Procedure::all();

        $menu[$this->parent_menu][$this->title] = true;

        return view(strtolower($this->title).'.add_edit')
            ->with('procedures', $procedures) 
            ->with('menu', $menu) 
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
        $item = ProcedureDone::find($id);
        $item->name = $request->name;
        $item->comment = $request->comment;
        $item->save();

        return Redirect::route('procedures_done.index');
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
            $item = ProcedureDone::find($id);

            $item->delete();
            throw new SuccessException;
        }
        catch(Exception $e){
             return ExceptionHelper::toResponse($e);
             }
    }
}
