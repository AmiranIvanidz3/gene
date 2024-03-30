<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Password;
use Exception;
use App\Exceptions\UserException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UserHelper
{
    /**
     * Checks user
     *
     * @param $user
     * @param $email
     * @return bool
     */
    public static function check($user = false, $email = false)
    {
        if($user){ return User::where('id', '=', $user)->exists(); }
        elseif($email){ return User::where('email', '=', $email)->exists(); }
        else{ return false; }
    }

    /**
     * Stores user
     *
     * @param $name
     * @param $lastName
     * @param $email
     * @param $password
     * @param $reset
     * @param $active
     * @param $channel_id
     * @return User
     * @throws Exception
     * @throws UserException
     */
    public static function store($name, $lastName, $email, $password, $reset = false, $active = true,  $channel_id = null)
    {
        if(self::check(false, $email)){ throw new UserException('User already exists'); }
        $password = bcrypt($password);
        $user = User::create([
            'name' => $name,
            'last_name' => $lastName,
            'email' => $email,
            'reset' => ($reset ? 1 : 0),
            'active' => ($active ? 1 : 0),
            'password' => $password,
            'password_set_at' => date('Y-m-d H:i:s'),
            'channel_id' => $channel_id
        ]);
        Password::create(['user_id' => $user->id, 'password' => $password]);
        return $user;
    }

    /**
     * Updates user
     *
     * @param $user
     * @param $name
     * @param $lastName
     * @param $email
     * @param $password
     * @param $reset
     * @param $active
     * @return User
     * @throws Exception
     * @throws UserException
     */
    public static function update($user, $name, $lastName, $email, $password = false, $reset = false, $active = true, $channel_id)
    {
        
        $user = self::get($user);

        if(User::where('email', '=', $email)->where('id', '!=', $user->id)->exists()){ throw new UserException('User already exists'); }


        $data = [
            'name' => $name,
            'last_name' => $lastName,
            'email' => $email,
            'active' => 1,
            'reset' => $reset,
            'channel_id' => $channel_id
        ];
        // if ($password) {
        //     $data = array_merge($data, [
        //         'password' => $password,
        //         'password_set_at' => date('Y-m-d H:i:s'),
        //     ]);
        // }
        
        $user->update($data);

        
        if(strlen($password) > 0)
        {
            $password = bcrypt($password);
            $user->update([
                'password' => $password,
                'password_set_at' => date('Y-m-d H:i:s')
            ]);
            Password::create(['user_id' => $user->id, 'password' => $password]);
        }
        return $user;
    }
    /**
     * Destroys territory
     *
     * @param $user
     * @param $identifier
     * @throws UserException
     * @return bool
     */
    public static function destroy($user = false, $identifier = false)
    {
        DB::beginTransaction();
        try
        {
            $user = self::get($user, $identifier);
            $user->delete();
        }
        catch(Exception $e)
        {
            DB::rollBack();
            throw new UserException('Record can not be deleted because of children objects');
        }
        DB::commit();

        return true;
    }

    /**
     * Gets user
     *
     * @param $user
     * @param $email
     * @return User
     * @throws UserException
     */
    public static function get($user = false, $email = false)
    {
        if(!self::check($user, $email)){ throw new UserException('User not found'); }
        if($user){ return User::where('id', '=', $user)->first(); }
        elseif($email){ return User::where('email', '=', $email)->first(); }
        else{ throw new UserException('Wrong identifier'); }
    }

    /**
     * Gets users
     *
     * @param $active
     * @return User
     */
    public static function users($active = true)
    {
        if($active){ return User::active()->get(); }
        else{ return User::get(); }
    }

    /**
     * Changes user password
     *
     * @param $current
     * @param $new
     * @param $user
     * @param $email
     * @return bool
     * @throws UserException
     * @throws Exception
     */
    public static function changePassword($current, $new, $user = false, $email = false)
    {
        $user = self::get($user, $email);
        if(!Hash::check($current, $user->password)){ throw new UserException('Current password is incorrect'); }
        if(!ConfigHelper::value('password', 'repeat'))
        {
            $oldPasswords = Password::where('user_id', '=', $user->id)->orderBy('id', 'desc');
            if(ConfigHelper::value('password', 'limit') >= 0){ $oldPasswords->take(ConfigHelper::value('password', 'limit')); }
            foreach($oldPasswords->get() as $oldPassword){ if(Hash::check($new, $oldPassword->password)){ throw new UserException('You can not set old passwords'); } }
        }
        $password = bcrypt($new);
        $user->update(['reset' => 0, 'active' => 1, 'password' => $password,  'password_set_at' => date('Y-m-d H:i:s')]);
        Password::create(['user_id' => $user->id, 'password' => $password]);
        return true;
    }

    /**
     * Resets user password
     *
     * @param $user
     * @param $email
     * @param $reset
     * @param $password
     * @return bool
     * @throws UserException
     * @throws Exception
     */
    public static function resetPassword($user = false, $email = false, $reset = true, $password = null)
    {
        $user = self::get($user, $email);
        if(is_null($password)){ $password = str_random(env('PASSWORD_LENGTH', 6)); }
        else
        {
            if(strlen($password) < env('PASSWORD_LENGTH', 6))
            {
                throw new UserException('Password length must be at least '. env('PASSWORD_LENGTH'. 6) .' characters');
            }
        }
        $password = Hash::make($password);
        $user->update(['reset' => ($reset ? 1 : 0), 'password' => $password, 'password_set_at' => date('Y-m-d H:i:s')]);
        Password::create(['user_id' => $user->id, 'password' => $password]);
        return true;
    }


    /**
     * Generates random string
     *
     *  @param $length
     */
    public static function generateRandomPassword($length = 8){
        return Str::random($length);
    }
}
