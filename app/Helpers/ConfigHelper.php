<?php

namespace App\Helpers;

use App\Models\Config;
use App\Exceptions\ConfigException;
use Illuminate\Support\Facades\Cache;

class ConfigHelper
{
    protected static $configTypes = ['bool', 'integer', 'float', 'string'];

    protected static $optionTypes = ['unlimited', 'range', 'list'];

    /**
     * Checks config
     *
     * @param $config
     * @param $group
     * @param $property
     * @return bool
     */
    public static function check($config = false, $group = false, $property = false)
    {
        if($config){ return Config::where('id', '=', $config)->exists(); }
        elseif($group && $property){ return Config::where('group', '=', $group)->where('property', '=', $property)->exists(); }
        else{ return false; }
    }

    /**
     * Stores config
     *
     * @param $group
     * @param $property
     * @param $type
     * @param $default
     * @param $value
     * @param array $options
     * @return Config
     * @throws ConfigException
     */
    public static function store($group, $property, $type, $default, $value = false, array $options = [])
    {
        if(!(strlen($group) > 0)){ throw new ConfigException('Group is required'); }
        if(!(strlen($property) > 0)){ throw new ConfigException('Property is required'); }
        if(self::check(false, $group, $property)){ throw new ConfigException('Group property already exists'); }
        if(!in_array($type, self::$configTypes)){ throw new ConfigException('Unsupported config type'); }
        if(!(strlen($default) > 0)){ throw new ConfigException('Default is required'); }
        if(empty($options)){ $options = ['type' => 'unlimited']; }
        elseif(isset($options['type']))
        {
            if(!in_array($options['type'], self::$optionTypes)){ throw new ConfigException('Unsupported option type'); }
            if($options['type'] == 'unlimited'){ $options = ['type' => 'unlimited']; }
            elseif($options['type'] == 'range' && (!isset($options['range']['from']) || !isset($options['range']['to']))){ throw new ConfigException('Options range is required'); }
            elseif($options['type'] == 'list' && !isset($options['list'])){ throw new ConfigException('Options list is required'); }
        }
        else{ throw new ConfigException('Option type is required'); }
        if($value === false){ $value = $default; }
        $config = Config::create([
            'group' => $group,
            'property' => $property,
            'type' => $type,
            'value' => $value,
            'default' => $default,
            'options' => $options
        ]);
        self::cache($config->id);
        return $config;
    }

    /**
     * Updates config
     *
     * @param $config
     * @param $group
     * @param $property
     * @param $type
     * @param $value
     * @param $default
     * @param array $options
     * @return Config
     * @throws ConfigException
     */
    public static function update($config, $group, $property, $type, $default, $value = false, array $options = [])
    {
        $config = self::get($config);
        if(!(strlen($group) > 0)){ throw new ConfigException('Group is required'); }
        if(!(strlen($property) > 0)){ throw new ConfigException('Property is required'); }
        if(Config::where('group', '=', $group)->where('property', '=', $property)->where('id', '!=', $config->id)){ throw new ConfigException('Group property already exists'); }
        if(!in_array($type, self::$configTypes)){ throw new ConfigException('Unsupported config type'); }
        if(!(strlen($default) > 0)){ throw new ConfigException('Default is required'); }
        if(empty($options)){ $options = $config->options; }
        elseif(isset($options['type']))
        {
            if(!in_array($options['type'], self::$optionTypes)){ throw new ConfigException('Unsupported option type'); }
            if($options['type'] == 'unlimited'){ $options = ['type' => 'unlimited']; }
            elseif($options['type'] == 'range' && (!isset($options['range']['from']) || !isset($options['range']['to']))){ throw new ConfigException('Options range is required'); }
            elseif($options['type'] == 'list' && !isset($options['list'])){ throw new ConfigException('Options list is required'); }
        }
        else{ throw new ConfigException('Option type is required'); }
        if($value === false){ $value = $config->value; }
        $config->update([
            'group' => $group,
            'property' => $property,
            'type' => $type,
            'value' => $value,
            'default' => $default,
            'options' => $options
        ]);
        return $config;
    }

    /**
     * Gets config
     *
     * @param $config
     * @param $group
     * @param $property
     * @return Config
     * @throws ConfigException
     */
    public static function get($config = false, $group = false, $property = false)
    {
        if(!self::check($config, $group, $property)){ throw new ConfigException('Config not found'); }
        if($config){ return Config::where('id', '=', $config)->first(); }
        elseif($group && $property){ return Config::where('group', '=', $group)->where('property', '=', $property)->first(); }
        else{ throw new ConfigException('Wrong identifier'); }
    }

    /**
     * Sets config value
     *
     * @param $group
     * @param $property
     * @param $value
     * @return bool
     * @throws ConfigException
     */
    public static function set($group, $property, $value = false)
    {
        $config = self::get(false, $group, $property);
        $config->update(['value' => $value]);
        return true;
    }

    /**
     * Gets config default
     *
     * @param $group
     * @param $property
     * @return mixed
     * @throws ConfigException
     */
    public static function default($group, $property)
    {
        return self::get(false, $group, $property)->default;
    }

    /**
     * Caches config
     *
     * @param $config
     * @param $group
     * @param $property
     * @return bool
     * @throws ConfigException
     */
    public static function cache($config = false, $group = false, $property = false)
    {
        $config = self::get($config, $group, $property);
        $data = [
            'group' => $config->group,
            'property' => $config->property,
            'type' => $config->type,
            'value' => $config->value,
            'default' => $config->default,
            'options' => $config->options
        ];
        Cache::forever('config|'.$config->group.'|'.$config->property, $data);
        return true;
    }

    /**
     * Caches all config
     *
     * @return bool
     * @throws ConfigException
     */
    public static function cacheAll()
    {
        foreach(Config::get() as $config){ self::cache($config->id); }
        return true;
    }

    /**
     * Gets config value
     *
     * @param $group
     * @param $property
     * @return mixed
     * @throws ConfigException
     */
    public static function value($group, $property)
    {
        $config = Cache::get('config|'.$group.'|'.$property);
        if(empty($config)){ if(self::cache(false, $group, $property)){ return self::value($group, $property); }}
        return $config['value'];
    }
}
