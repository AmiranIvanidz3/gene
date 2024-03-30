<?php
namespace App\Http\Controllers;

use Exception;
namespace App\Http\Controllers;
use Exception;
use App\Models\Parameter;
use Illuminate\Http\Request;
use App\Helpers\ExceptionHelper;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\DB;
use App\Exceptions\SuccessException;
use Illuminate\Support\Facades\Artisan;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\AddCalDayTypelRequest;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Month;

class ParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $title = 'Parameters';
    public $title_kebab = 'Parameters';
    public $parent_menu = 'settings';
    public $breadcrumb_icon = 'flaticon-cogwheel-2';


    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('password');
    }


    public function index()
    {
       

        $menu['Settings'][$this->title] = true;

        return view(strtolower($this->title_kebab).'.view')
            ->with('menu', $menu) 
            ->with('page_title',ucwords(str_replace("-", " ", $this->parent_menu)))
            ->with('breadcrumbs', [
                ['title' =>  ucwords(str_replace("-", " ", $this->title)), 'url' => adminUrl($this->title)]
            ])
            ->with('breadcrumb_icon', $this->breadcrumb_icon);
    }


    public function parameterList(Request $request)
    {
        $query = Parameter::get();

        return DataTables::of($query)->toJson();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $menu['Settings'][$this->title] = true;


        

        return view(strtolower($this->title_kebab).'.add_edit')
        ->with('action', 'add')
        ->with('page_title', ucwords(str_replace("-", " ", $this->parent_menu)))
        ->with('breadcrumbs', [
            ['title' =>  ucwords(str_replace("-", " ", $this->title)), 'url' => adminUrl($this->title)],
            ['title' => env('CREATE_NEW')]
         ])
        ->with('menu', $menu)
        ->with('breadcrumb_icon', $this->breadcrumb_icon);

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
            $question = new Parameter();
            $question->key = $request->key;
            $question->value = $request->value;
            $question->description = $request->description;
            $question->save();
            
            if($question->key == 'admin_dir'){
                Artisan::call('route:cache');
            }
        }
        catch(Exception $e)
        {
            // return back()->with('response', ['success' => false, 'data' => 'Error occured']);
            throw new Exception($e->getMessage());
        }
            return redirect(env('ADMIN_URL').'/parameters')->with('response', ['success' => true, 'data' => 'Success']);
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
           
        $item = Parameter::find($id);
        
        $menu['Settings'][$this->title] = true;

        return view(strtolower($this->title).'.add_edit')
            ->with('menu', $menu) 
            ->with('page_title',ucwords(str_replace("-", " ", $this->parent_menu))) 
            ->with('breadcrumbs', [
                ['title' =>  ucwords(str_replace("-", " ", $this->title)), 'url' => adminUrl($this->title)],
                ['title' => "Edit"]
             ])
            ->with('item', $item)
            ->with('action', 'edit')
            ->with('breadcrumb_icon', $this->breadcrumb_icon);
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
        $question = Parameter::find($id);
        $question->key = $request->key;
        $question->value = $request->value;
        $question->description = $request->description;
        $question->save();

        if($question->key == 'admin_dir'){
            return redirect('route-cache');
        }
        return redirect(env('ADMIN_URL').'/parameters');
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
            $item = Parameter::find($id);

            $item->delete();
            throw new SuccessException;
        }
        catch(Exception $e){ return ExceptionHelper::toResponse($e); }
    }

}
