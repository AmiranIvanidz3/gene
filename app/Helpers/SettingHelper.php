<?php

namespace App\Helpers;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Cookie;

class SettingHelper
{
    public static function get($settingName)
    {
        $settingValue = Cookie::get($settingName);
        if(!empty($settingValue))
        {
            $value = explode('<<<>>>', $settingValue)[0];
            if(in_array($value, self::options($settingName)))
            {
                $hash = explode('<<<>>>', $settingValue)[1];
                if(Helper::hash([$settingName, $value, Helper::secret()]) === $hash){ return $value; }
                else{ return self::defaults($settingName); }
            }
            else{ return self::defaults($settingName); }
        }
        else{ return self::defaults($settingName); }
    }

    public static function set($settingName, $value)
    {
        $settingValue = $value .'<<<>>>'. Helper::hash([$settingName, $value, Helper::secret()]);
        Cookie::queue(Cookie::make($settingName, $settingValue, 518400));
        return true;
    }

    public static function defaults($settingName)
    {
        return config('settings.'.$settingName.'.default');
    }

    public static function options($settingName)
    {
        return config('settings.'.$settingName.'.options');
    }
}
