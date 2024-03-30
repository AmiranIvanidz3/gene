<?php

namespace App\Helpers;

use App\Models\Category;
use DB;


// use App\Models\PublishedCategory;

class TreeHelper
{


    public static function getTreeData($table, $columns = false, $order_priority = false){
        // dd($order_priority);
        $columns_str = '';
        if(is_array($columns)){
            $cnt = count($columns);
            for($i = 0; $i < $cnt; $i++){
                $columns_str .= $table.'.'.$columns[$i].',';
            }
            
        }else{
            $columns_str = 'c1.*,';
        }

        $query = "SELECT
            $columns_str
            -- c1.order_priority,
            (
                SELECT
                    Count(c2.id)
                FROM
                    $table AS c2
                WHERE
                    c2.parent_id = c1.id
            )
            AS children_count
        FROM
            $table AS c1
        -- WHERE c1.parent_id IS NULL
            ORDER BY ".($order_priority ? 'order_priority' : 'id')." DESC";
        // dd($query);
        return json_decode(json_encode(DB::select($query)), true);
    }







    /**
     * Get json tree of given data or select it from db. Either give predefined $data or table param from settings to let it select from table correctly
     *
     * @param  array  $settings
     * @param  array|null  $columns
     * 
     * @return string
     */
    public static function getTreeJSON($settings = [], $data = null)
    {
        foreach(['table', 'columns', 'order_priority', 'combo_tree', 'filter'] as $key){
            ${$key} = $settings[$key] ?? null;
        }

        if(!$data && !$table){
            return;
        }


        $details = $data ? $data : self::getTreeData($table, $columns, $order_priority);
        $array_tree = self::getTreeArray($details, null, $combo_tree, $filter);
        // dd($array_tree);

        return json_encode($array_tree, JSON_HEX_APOS);
    }










    public static function getTreeArray($items, $parent_id = null, $combo_tree = null, $filter = null)
    {
        // dd($filter);
        $array_JSON = [];
        $menu = "";

        $display_text_key = $combo_tree ? 'title' : 'text';
        $id_prefix = $combo_tree ? '' : 'jstreeItem-';
        $children_key = $combo_tree ? 'subs' : 'children';
        // dd($items);
        foreach ($items as $item) {
            if ($item['parent_id'] == $parent_id) {

                if ($item['children_count'] > 0) {

                    $array_JSON[] = [
                        $display_text_key => $item['name'],
                        $children_key => self::getTreeArray($items, $item['id'], $combo_tree, $filter),
                        'id' => $id_prefix.$item['id']
                    ]+($filter ? ['toFilter' => $item[$filter]] : []);
                } else {
                    $array_JSON[] = [
                        $display_text_key => $item['name'],
                        'id' => $id_prefix.$item['id']
                    ]+($filter ? ['toFilter' => $item[$filter]] : []);
                }

            }
        }
        return $array_JSON;
    }














    
    public static function UpdateParentAndPosition($request, $model){
        $id = $request->id;

        $old_position = $request->old_position;
        $position = $request->position;

        // $old_parent = str_contains($request->old_parent, '-') ? explode('-', $request->old_parent)[1] : null;
        // $parent = str_contains($request->parent, '-') ? explode('-', $request->parent)[1] : null;
        $old_parent = $request->old_parent !== 'undefined' ? $request->old_parent : null;
        $parent = $request->parent !== 'undefined' ? $request->parent : null;
        // dd($parent);
        $parent_changed = false;

        if($old_parent !== $parent){
            $parent_changed = true;
        }

        $new_priority = null;
        // $to_replace = Category::where('parent_id', $parent)->orderBy('order_priority', 'DESC')->offset($position)->limit(1)->first()->order_priority ?? null;

        $full_data = $model::where('parent_id', $parent)->orderBy('order_priority', 'DESC')->offset($position - 1)->limit(3)->get();
        // dd($full_data);

        // dd($position,$to_replace);

        if(!$parent_changed && $old_position < $position){ //moved existing child in front

            // order priority more than 'to_replace' and less than 'after to_replace'

            $to_replace = $full_data[1]->order_priority ?? null;
            if(isset($full_data[2])){
                $after = $full_data[2]->order_priority ?? null;
                $new_priority = ($to_replace + $after)/2;
            }else{ // moved at the end
                $to_replace = $full_data[1]->order_priority ?? null;
                $new_priority = $to_replace / 2;
            }

            

        }else{ //moved from outside node or moved back from previous position
            
            // order priority less than 'to_replace' and more than 'before to_replace', if position === 0 then half of 'to_replace'
            if($position === '0'){
                $to_replace = $full_data[0]->order_priority ?? null;
                $new_priority = $to_replace ? $to_replace + 1 : 1;

            }elseif(!isset($full_data[1])){ //if category is moved from outside to the end of the node

                $last_child = $full_data[0]->order_priority ?? null;

                $new_priority = $last_child / 2;
            
            }else{
                $to_replace = $full_data[1]->order_priority ?? null;
                // $before_to_replace = Category::where('parent_id', $parent)->orderBy('order_priority', 'DESC')->offset($position - 1)->limit(1)->first()->order_priority;
                $before_to_replace = $full_data[0]->order_priority ?? null;
                $new_priority = ($to_replace + $before_to_replace)/2;
            }
        }

        // dd([
        //     '$id' => $id,
        //     '$position' => $position,
        //     '$new_priority' => $new_priority,
        //     '$request->all()' => $request->all(),
        //     'full_data' => $full_data,
        //     '$to_replace' => $to_replace ?? null,
        // ]);

        $instance = $model::find($id);
        if($parent_changed){ 
            $instance->parent_id = $parent;
        }

        $instance->order_priority = $new_priority;
        $instance->save();

        // dd([
        //     '$new_priority' => $new_priority,
        //     '$request->all()' => $request->all(),
        //     '$to_replace' => $to_replace,
        // ]);
    }





}
