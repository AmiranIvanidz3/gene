<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Helpers\Helper;
use App\Helpers\ConfigHelper;
use Illuminate\Support\Facades\Auth;

class CheckPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @throws Exception
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check())
        {
            if(Auth::user()->reset == 1){ return redirect(env('ADMIN_URL').'/profile/change/password'); }
            if(ConfigHelper::value('password', 'change'))
            {
                if(Helper::daysInterval(Auth::user()->password_date) > ConfigHelper::value('password', 'interval')){ return redirect('profile/change/password'); }
            }
        }
        return $next($request);
    }
}
