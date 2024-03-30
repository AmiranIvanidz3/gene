<?php

namespace App\Http\Controllers;

use Exception;
use ErrorException;
use App\Models\User;
use App\Models\Author;
use App\Helpers\UserHelper;
use App\Helpers\ExceptionHelper;
use Spatie\Permission\Models\Role;
use App\Exceptions\SuccessException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditProfileRequest;
use App\Http\Requests\ChangePasswordRequest;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('password')->except('getProfileChangePassword', 'postProfileChangePassword');
    }

    public function getProfileChangePassword()
    {
        return view('profile.change.password')
            ->with('breadcrumbs', [['title' => 'change password']])
            ->with('page', 'password');
    }


    public function postProfileChangePassword(ChangePasswordRequest $request)
    {
        UserHelper::changePassword($request->input('current_password'), $request->input('new_password'),Auth::user()->id);
        return redirect( adminUrl("/") );
    }

    public function getProfileChange(User $user){
        return view('users.profile-change')
        ->with('breadcrumbs', [['title' => 'Change Profile']])
        ->with('page', 'password')
        ->with('user', $user)
        ->with('action', 'edit');
    }
    public function postProfileChange(Request $request){
        $users = User::find($id);

        try
        {
            $user = UserHelper::Update(
                $users->id,
                $request->input('name'),
                $request->input('last_name'),
                $request->input('email'),
                $request->input('password'),
                true,
                $request->input('active'));

            $role = Role::find($request->role_id);
            $user->syncRoles($role);


        }
        catch(Exception $e)
        {
            throw new ErrorException($e->getMessage());
        }
        throw new SuccessException;

             
             
          
        

           

          
      
    }
}

