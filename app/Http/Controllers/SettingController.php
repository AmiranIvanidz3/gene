<?php

namespace App\Http\Controllers;


use App\Helpers\SettingHelper;
use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;
use App\Exceptions\ErrorPageException;
use App\Exceptions\SuccessException;

use App\Helpers\ConfigHelper;

use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{

    public $title = 'security';
    public $title_kebab = 'security';
    public $parentMenu = 'Settings';
    public function __construct()
    {
        $this->middleware(['auth', 'password']);
        
    }

    public function getSet($settingName, $value)
    {
        SettingHelper::set($settingName, $value);
        return back();
    }

    public function getSettingsSecurity()
    {
        if(!Auth::user()->can('security:view')){ throw new ErrorPageException(403); }
        $config = [];

        foreach(Config::password()->get() as $property){ $config[$property->group][$property->property] = $property->value; }
        $menu[$this->parentMenu][$this->title] = true;
        return view('settings.security.index')
            ->with('menu', $menu) 
            ->with('breadcrumbs', [['title' => 'security settings']])
            ->with('config', $config);
    }

    public function postSettingsSecurity(Request $request)
    {
        if(!Auth::user()->can('security:add')){ throw new ErrorPageException(403); }
        ConfigHelper::set('password', 'change', ($request->input('password_change') == 1 ? 1 : 0));
        ConfigHelper::set('password', 'interval', $request->input('password_interval'));
        ConfigHelper::set('password', 'repeat', ($request->input('password_repeat') == 1 ? 1 : 0));
        ConfigHelper::set('password', 'limit', $request->input('password_limit'));

        throw new SuccessException;
    }

    public function getSettingsSecuritySetDefaults()
    {
        if(!Auth::user()->can('security:add')){ throw new ErrorPageException(403); }
        ConfigHelper::set('password', 'change', ConfigHelper::defaults('password', 'change'));
        ConfigHelper::set('password', 'interval', ConfigHelper::defaults('password', 'interval'));
        ConfigHelper::set('password', 'repeat', ConfigHelper::defaults('password', 'repeat'));
        ConfigHelper::set('password', 'limit', ConfigHelper::defaults('password', 'limit'));

        return back();
    }

    public function getSettingsLanguage()
    {
        if(!Auth::user()->can('security:view')){ throw new ErrorPageException(403); }
        return view('admin.settings.language.view')
            ->with('tab', 'settings');
    }





}
