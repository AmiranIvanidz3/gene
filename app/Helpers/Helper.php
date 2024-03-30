<?php

namespace App\Helpers;

use DateTime;
use Exception;
use App\Models\Parameter;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;

class Helper
{
    // Refactored functions

    public static function unset(array &$array, $key = false, $value = false)
    {
        if($key){ unset($array[$key]); }
        elseif($value){ if(($key = array_search($value, $array)) !== false){ unset($array[$key]); }}
    }

    public static function hex(int $length = 20) : string
    {
        return bin2hex(random_bytes($length));
    }

    public static function adminUrl($url)
    {
        return url(Parameter::getValue('admin_dir').'/'.$url);
    }

    public static function externalUrl($url)
    {
        return url(env('EXTERNAL_URL', '').'/'.$url);
    }

    // Not refactored functions

    public static function date($value, $format = false)
    {
        $format = $format ? $format : 'Y-m-d';
        $date = DateTime::createFromFormat($format, $value);
        return $date && $date->format($format) === $value;
    }

    public static function daysInterval($from, $to = false)
    {
        $from = new DateTime($from);
        $to = new DateTime(($to ? $to : date('Y-m-d H:i:s')));
        return $to->diff($from)->format("%a");
    }

    public static function minutesInterval($from, $to = false)
    {
        $from = new DateTime($from);
        $to = new DateTime(($to ? $to : date('Y-m-d H:i:s')));
        return intval(($from->getTimestamp() - $to->getTimestamp()) / 60);
    }

    public static function secondsInterval($from, $to = false)
    {
        $from = new DateTime($from);
        $to = new DateTime(($to ? $to : date('Y-m-d H:i:s')));
        return intval($from->getTimestamp() - $to->getTimestamp());
    }

    public static function formatDate($date, $format = false)
    {
        if($format){ return date($format, strtotime($date)); }
        else{ return date('d-m-Y', strtotime($date)); }
    }



}
