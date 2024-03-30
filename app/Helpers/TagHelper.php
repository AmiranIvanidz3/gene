<?php

namespace App\Helpers;

use App\Models\Tag;

use App\Models\tagOfProjectProcess;


class TagHelper
{
    /**
     * @param $tags
     * @return array
     */
    public static function getTagIds($tags)
    {
        $tag_IDs = [];
        
        foreach ($tags as $tag) {
            $tag_IDs[] = Tag::firstOrCreate(['name'=>$tag])->id;
        }

        return $tag_IDs;
    }


    public static function createOrGetIds($tags, $class_name = 'TagOfProjectAsset'){
        $tag_IDs = [];

        $class_name = 'App\\Models\\'.$class_name;
        
        foreach ($tags as $tag) {
            $tag_IDs[] = $class_name::firstOrCreate(['name'=>$tag])->id;
        }

        return $tag_IDs;
    }


    /**
     * @param $tags
     * @return array
     */
    public static function selectTagIdsByName($tags, $class_name = 'TagOfProjectAsset')
    {
        $tag_IDs = [];

        $class_name = 'App\\Models\\'.$class_name;
        
        foreach ($tags as $tag) {
            $tag = $class_name::where(['name'=>$tag])->first();
            if($tag){
                $tag_IDs[] = $tag->id;
            }
        }

        return $tag_IDs;
    }

    public static function selectTagModelsByName($tags, $class_name = 'TagOfProjectAsset')
    {
        $tag_IDs = [];

        $class_name = 'App\\Models\\'.$class_name;
        
        foreach ($tags as $tag) {
            $tag = $class_name::where(['name'=>$tag])->first();
            if($tag){
                $tag_IDs[] = $tag;
            }
        }

        return $tag_IDs;
    }


}
