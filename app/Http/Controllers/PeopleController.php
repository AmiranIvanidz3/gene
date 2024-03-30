<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\People;
use Illuminate\Http\Request;
use App\Helpers\ExceptionHelper;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\DB;
use App\Exceptions\SuccessException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $title = 'people';
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

    
    public function peopleList(Request $request)
    {
        $query = DB::select("SELECT * from people");

        return DataTables::of($query)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function create()
    {
        $menu[$this->parent_menu][$this->title] = true;
        $fathers = People::get();
        $mothers = People::get();

        return view(strtolower($this->title).'.add_edit')
            ->with('action', 'add')
            ->with('fathers', $fathers)
            ->with('mothers', $mothers)
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
            $item = new People();
            $item->mother_id = $request->mother_id;
            $item->father_id = $request->father_id;
            $item->name	 = $request->name;
            $item->surname = $request->surname;
            $item->gender_id = $request->gender_id;
            $item->birth_date = $request->birth_date;
            $item->personal_number = $request->personal_number;
            $item->about = $request->about;
            $item->comment = $request->comment;
            $item->died = $request->died;
            $item->save();
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }

            return Redirect::route('people.index');
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
           
        $item = People::find($id);
        
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
        $item = People::find($id);
        $item->name = $request->name;
        $item->personal_id = $request->personal_id;
        $item->physical_address	 = $request->physical_address	;
        $item->legal_address = $request->legal_address;
        $item->phone = $request->phone;
        $item->mobile_phone = $request->mobile_phone;
        $item->comment = $request->comment;
        $item->save();

        return Redirect::route('people.index');
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
            $item = People::find($id);

            $item->delete();
            throw new SuccessException;
        }
        catch(Exception $e){
             return ExceptionHelper::toResponse($e);
             }
    }
}
