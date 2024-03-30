<?php
namespace App\Traits;

trait ReorderTrait {

    public function reorderPriority($model, $priority_column = null, $table = null){

        if(!$table){
            //get table name from model somehow
        }

        $data = request()->validate([
            'target_id' => ['required', 'integer', 'exists:'.$table.',id'],
            'type' => ['in:top,bottom']
        ]);

        $target_priority = \DB::table($table)
            ->where('id', $data['target_id'])
            ->selectRaw($priority_column.' as order_priority')
            ->first()->order_priority;

            

        if($data['type'] === 'top'){

            $next_min = \DB::table($table)
            ->where($priority_column, '>', $target_priority)
            ->where($priority_column, '<=', $target_priority+1)
            ->selectRaw('MIN('.$priority_column.') as next_min')
            ->first()->next_min;

            if(!$next_min){
                $new_priority = ($target_priority + $target_priority + 1)/2;
            }else{
                $new_priority = ($target_priority + $next_min)/2;
            }


        }


        if($data['type'] === 'bottom'){

            $before_max = \DB::table($table)
            ->where($priority_column, '<', $target_priority)
            ->where($priority_column, '>=', $target_priority-1)
            ->selectRaw('MAX('.$priority_column.') as before_max')
            ->first()->before_max;

            if(!$before_max){
                $new_priority = ($target_priority + 1)/2;
            }else{
                $new_priority = ($target_priority + $before_max)/2;
            }


        }        
        //order_priority    order
        $model->{$priority_column} = $new_priority;
        $model->save();
        // $model->update([$priority_column => $new_priority]);

        return response()->json([
            'success' => true,
            'data' => [
                'message' => [
                    'model' => $model, 
                ]
            ]
        ]);


    }


}