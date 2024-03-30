<?php

namespace App\Providers;

use View;
use App\Models\Log;

use App\Models\Parameter;

use App\Models\RiskState;
use App\Models\TaskState;
use Illuminate\Auth\Events\Login;
use App\Models\RiskTreatmentState;
use Illuminate\Auth\Events\Logout;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use App\Models\DocumentApprovalState;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\LogController;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->app['events']->listen(Login::class, function ($event) {
            LogController::store("Login");
        });

        $this->app['events']->listen(Logout::class, function ($event) {
            LogController::store("Logout");
        });

        Paginator::useBootstrap();


        // Admin URL from DB Logic Section --START--
        $adminUrl = Parameter::getValue('admin_dir');
        
        putenv("ADMIN_URL={$adminUrl}"); 
        // Admin URL from DB Logic Section --END--

    }
}
