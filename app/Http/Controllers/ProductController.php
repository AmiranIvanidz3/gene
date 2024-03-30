<?php
namespace App\Http\Controllers;
use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\ExceptionHelper;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\DB;
use App\Exceptions\SuccessException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $title = 'products';
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

    public function productList(request $request)
    {
        $query = Product::with('unitType', 'productType')->get();

        return DataTables::of($query)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unit_types =  DB::select('SELECT * FROM unit_type');
        $product_types = DB::select('SELECT * FROM product_type');
        $menu[$this->parent_menu][$this->title] = true;

        return view(strtolower($this->title).'.add_edit')
        ->with('product_types', $product_types)
        ->with('unit_types', $unit_types)
        ->with('action', 'add')
        ->with('menu', $menu);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $item = new Product();
            $item->name = $request->name;
            $item->unit_type_id = $request->unit_type_id;
            $item->product_type_id = $request->product_type_id;
            $item->code = $request->code;
            $item->bar_code = $request->bar_code;
            $item->internal_code = $request->internal_code;
            $item->save();
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }

            return Redirect::route('products.index');
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
        $item = Product::find($id);
        $unit_types =  DB::select('SELECT * FROM unit_type');
        $product_types = DB::select('SELECT * FROM product_type');

        $menu[$this->parent_menu][$this->title] = true;

        return view(strtolower($this->title).'.add_edit')
            ->with('product_types', $product_types)
            ->with('unit_types', $unit_types)
            ->with('menu', $menu) 
            ->with('item', $item)
            ->with('action', 'edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(request $request, $id)
    {
        $item = Product::find($id);
        $item->name = $request->name;
        $item->unit_type_id = $request->unit_type_id;
        $item->product_type_id = $request->product_type_id;
        $item->code = $request->code;
        $item->bar_code = $request->bar_code;
        $item->internal_code = $request->internal_code;
        $item->save();

        return Redirect::route('products.index');
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
            $item = Product::find($id);

            $item->delete();
            throw new SuccessException;
        }
        catch(Exception $e){
             return ExceptionHelper::toResponse($e);
             }
    }
}
