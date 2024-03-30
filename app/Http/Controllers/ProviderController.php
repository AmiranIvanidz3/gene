<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Provider;
use Illuminate\Http\Request;
use App\Helpers\ExceptionHelper;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\DB;
use App\Exceptions\SuccessException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $title = 'providers';
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

    public function providerList(Request $request)
    {
        $query = Provider::query();

        $filters = [
            'id',
            'name',
            'personal_id',
            'physical_address',
            'legal_address',
            'phone',
            'mobile_phone',
            'comment',
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
        $menu[$this->parent_menu][$this->title] = true;
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
            $item = new Provider();
            $item->name = $request->name;
            $item->personal_id = $request->personal_id;
            $item->physical_address	 = $request->physical_address	;
            $item->legal_address = $request->legal_address;
            $item->phone = $request->phone;
            $item->mobile_phone = $request->mobile_phone;
            $item->comment = $request->comment;
            $item->save();
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }

            return Redirect::route('providers.index');
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
           
        $item = Provider::find($id);
        
        $menu[$this->parent_menu][$this->title] = true;

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
        $item = Provider::find($id);
        $item->name = $request->name;
        $item->personal_id = $request->personal_id;
        $item->physical_address	 = $request->physical_address	;
        $item->legal_address = $request->legal_address;
        $item->phone = $request->phone;
        $item->mobile_phone = $request->mobile_phone;
        $item->comment = $request->comment;
        $item->save();

        return Redirect::route('providers.index');
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
            $item = Provider::find($id);

            $item->delete();
            throw new SuccessException;
        }
        catch(Exception $e){
             return ExceptionHelper::toResponse($e);
             }
    }
}
