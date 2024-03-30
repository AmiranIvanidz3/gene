<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\ProductType;
use App\Models\Parameter;
use Illuminate\Http\Request;
use App\Helpers\ExceptionHelper;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\DB;
use App\Exceptions\SuccessException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class ProductTypeController extends Controller
{
    public $title = 'product-types';
    public $parent_menu = 'administration';
    public $submenu = 'products';


    
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

    public function productTypeList(Request $request)
    {
        $query = ProductType::query();

        $filters = [
            'id',
            'name',
            'comment'
        ];
    
        foreach ($filters as $value) {
            if ($request->has($value) && $request->$value != null) { 
                 $query->where($value, 'like', '%' . $request->$value . '%');
            }
        }

        if($request->from_date_filter){
            $date = Carbon::parse($request->from_date_filter)->format('Y-m-d');
            $query->whereDate("created_at", ">=", $date);
        }
        
        if($request->to_date_filter){
            $date = Carbon::parse($request->to_date_filter)->format('Y-m-d');
            $query->whereDate("created_at", "<=", $date);
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
        //


        $menu[$this->parent_menu][$this->submenu][$this->title] = true;

        

        return view(strtolower($this->title).'.add_edit')
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
            $ProductType = new ProductType();
            $ProductType->name = $request->name;
            $ProductType->comment = $request->comment;
            $ProductType->save();
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }

            return Redirect::route('product-types.index');
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
           
        $item = ProductType::find($id);
        

        $menu[$this->parent_menu][$this->submenu][$this->title] = true;
        return view(strtolower($this->title).'.add_edit')
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
        $ProductType = ProductType::find($id);
        $ProductType->name = $request->name;
        $ProductType->comment = $request->comment;
        $ProductType->save();

        return Redirect::route('product-types.index');
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
            $item = ProductType::find($id);

            $item->delete();
            throw new SuccessException;
        }
        catch(Exception $e){
             return ExceptionHelper::toResponse($e);
             }
    }
}
