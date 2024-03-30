<?php

namespace App\Http\Livewire;
use App\Models\Reel;
use App\Models\User;
use Livewire\Component;
use App\Models\ReelStatus;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\LogController;

class ReelsTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    #[Url(history:true)]
    public $search = '';
    

    public $success_message;

    #[Url(history:true)]
    public $admin = '';

    #[Url(history:true)]
    public $sortBy = 'created_at';

    #[Url(history:true)]
    public $sortDir = 'DESC';

    #[Url()]
    public $perPage = 5;


    public function updatedSearch(){
        $this->resetPage();
    }

    public function delete(Reel $reel){
        $reel->delete();
    }

    public function changeStatus($id,$value){
        
        $item = Reel::find($id);

        $new_data = ReelStatus::where('id', $value)->pluck('name')->first();

        $old_data = ReelStatus::where('id', $item->status_id )->pluck('name')->first();

        $data = ["old" => $old_data, "new" => $new_data];

        
       
        
        LogController::store("Change Reel Status", $data, request()->ip());

       
        $item->status_id = $value;
        $item->save();
        if($id == 40){
            $item->published_at = date('Y-m-d H:i:s');
        }
    }

    

    public function setSortBy($sortByField){

        if($this->sortBy === $sortByField){
            $this->sortDir = ($this->sortDir == "ASC") ? 'DESC' : "ASC";
            return;
        }

        $this->sortBy = $sortByField;
        $this->sortDir = 'DESC';
    }

    public function render()
    {
    return view('livewire.reels-table',
    [
        'users' =>   DB::table('reels')
            ->select(
                'reels.*',
                'videos.id as video_id',
                'videos.title as video_title', 
                'authors.name as author_name', 
                'reel_statuses.id as reel_statuses_id', 
                'reel_statuses.image as status_image',
                'reel_statuses.name as status_name'
            )
            ->join('videos', 'videos.id', '=', 'reels.video_id')
            ->join('authors', 'authors.id', '=', 'reels.author_id')
            ->join('reel_statuses', 'reel_statuses.id', '=', 'reels.status_id')
            ->paginate($this->perPage),
        'statuses' => ReelStatus::all()
    ]
        );
    }
}
