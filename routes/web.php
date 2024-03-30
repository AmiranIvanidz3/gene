<?php

use App\Models\Parameter;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReelController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ModalNewController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\UnitTypeController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\PublicApiController;
use App\Http\Controllers\VisitTypeController;
use App\Http\Controllers\ClientCityController;
use App\Http\Controllers\ExcludedIpController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ReelStatusController;
use App\Http\Controllers\VisitPlaceController;
use App\Http\Controllers\VisitStateController;
use App\Http\Controllers\NewsRequestController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ProcedureDoneController;
use App\Http\Controllers\ProcedureTypeController;
use App\Http\Controllers\ProcedureGroupController;
use App\Http\Controllers\ExcludedUserAgentController;
use App\Http\Controllers\External\ExternalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['prefix' => env('ADMIN_URL'), ], function(){
Route::get('/', [HomeController::class, 'index']);

Route::get('/loginResponse', function(){
    return redirect(env('ADMIN_URL'));
}); 

Route::get('/route-cache', function(){
    Artisan::call('route:cache');
    return redirect(env('ADMIN_URL')."/parameters");
}); 
// Roles routes
Route::resource('roles', RoleController::class);
Route::post('roles/list', [RoleController::class, 'roleList']);
// Roles API requests
Route::get('api/roles/{id}/permissions', [RoleController::class, 'rolePermissions']);
/*  
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------ChangePasswordRequest------------------------------
*/

Route::get('profile/{user}/edit',[ProfileController::class, 'getProfileChange']);
Route::put('profile/{user}/edit',[ProfileController::class, 'postProfileChange']);


Route::get('profile/change/password',[ProfileController::class, 'getProfileChangePassword']);
Route::post('profile/change/password',[ProfileController::class, 'postProfileChangePassword']);





// Users routes
Route::resource('users', UserController::class);
Route::post('users/action/reorder/{user?}', [UserController::class, 'callReorderPiority']);
Route::post('users/list',[UserController::class, 'usersList']);

Route::put('api/{table_name}/{column_id}/{selected_id}/updateUser', [UserController::class, 'updateUser']);


/*
|--------------------------------------------------------------------------
| Setting
|--------------------------------------------------------------------------
*/
Route::get('settings', function(){
    return Redirect::route('parameters.index');
});

Route::get('set/{settingName}/{value}', [SettingController::class, 'getSet']);
Route::get('settings/security', [SettingController::class, 'getSettingsSecurity']);
Route::post('settings/security', [SettingController::class, 'postSettingsSecurity']);
Route::get('settings/security/set/defaults', [SettingController::class, 'getSettingsSecuritySetDefaults']);

Route::get('logs',[LogController::class, 'index']);
Route::post('logs/list',[LogController::class, 'logList']);

Route::get('group-log-reels/{group}', [LogController::class, 'groupLogIndex']);
Route::post('group-log-reels/list/{group}', [LogController::class, 'grouplogMentionList']);

Route::get('group-log-ip/{group}', [LogController::class, 'groupLogIpIndex']);
Route::post('group-log-ip/list/{group}', [LogController::class, 'grouplogIpList']);

Route::get('group-log-ua/{group}', [LogController::class, 'groupLogUAIndex']);
Route::post('group-log-ua/list/{group}', [LogController::class, 'grouplogUAList']);

Route::get('group-log-reel-statistic', [LogController::class, 'grouplogstatistiIndex']);
Route::post('group-log-reel-statistic/list', [LogController::class, 'grouplogstatisticList']);

Route::resource('comments', CommentController::class);
Route::post('comments/list',[CommentController::class, 'commentList']);
Route::post('seen',[CommentController::class, 'setSeen']);

Route::resource('excluded-ips', ExcludedIpController::class);
Route::post('excluded-ips/list', [ExcludedIpController::class, 'excludedIpList']);
Route::post('exclude-ip', [ExcludedIpController::class, 'excludeIp']);

// IP Requests Routes
Route::get('/ip-requests', [ExcludedIpController::class, 'ipRequestIndex']);
Route::post('ip-requests/list',[ExcludedIpController::class, 'ipRequestList']);

Route::resource('excluded-user-agents', ExcludedUserAgentController::class);
Route::post('excluded-user-agents/list', [ExcludedUserAgentController::class, 'excludedUserAgentsList']);
Route::post('exclude-ua', [ExcludedUserAgentController::class, 'excludeUA']);

// IP Requests Routes
Route::get('/excluded-user-agent-requests', [ExcludedUserAgentController::class, 'ExcludedUserAgentRequestsIndex']);
Route::post('excluded-user-agent-requests/list',[ExcludedUserAgentController::class, 'ExcludedUserAgentRequestsList']);

Route::resource('permissions', PermissionController::class);
Route::post('permissions/list',[PermissionController::class, 'permissionList']);


Route::resource('parameters', ParameterController::class);
Route::post('parameters/list', [ParameterController::class, 'parameterList']);

Route::get('log-visitors',[LogController::class, 'visitorIndex']);
Route::post('log-visitors/list', [LogController::class, 'logVisitorsList']);

Route::resource('modal-news', ModalNewController::class);
Route::post('modal-news/list', [ModalNewController::class, 'modalNewList']);
Route::post('modal-new-status', [ModalNewController::class, 'changeNewModalStatus']);

Route::get('log-news', [ModalNewController::class, 'logNewsIndex']);
Route::post('log-news/list', [ModalNewController::class, 'logNewsList']);


/*
|--------------------------------------------------------------------------
| GENE Resources Routes START
|--------------------------------------------------------------------------
*/
Route::resource('people', PeopleController::class);
Route::post('people/list', [PeopleController::class, 'peopleList']);
/*
|--------------------------------------------------------------------------
|  GENE Resources Routes  END
|--------------------------------------------------------------------------
*/

});
/*
|--------------------------------------------------------------------------
| Client web routes
|--------------------------------------------------------------------------
*/

   

Route::prefix(env('EXTERNAL_URL', ''))->group(function () {
    

    Route::get('/loginResponse', function(){
        return Redirect::route('parameters.index');
    }); 
    
    Route::post('get-news', [NewsRequestController::class, 'getNews']);

    Route::post('seen-new', [NewsRequestController::class, 'userSeenNews']);

});
