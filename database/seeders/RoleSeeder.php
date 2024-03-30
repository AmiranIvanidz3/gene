<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $roles = [
            'Admin',
            'Manager',
            'User',
            'Author',
            'Playlist',
            'Channel'
        ];

        $user_excluded_permissions = [
            'user:view',
            'user:add',
            'user:update',

            'role:view',
            'role:add',
            'role:update',   

            'tasks:manager',
            'task:view-all',
            'tasks:add',
            'task:update',

            'risk-treatment:view-all',
            'risk-treatment:update',
            
        ];

        $author_permissions = [
            'video:view',
            'video:add',

            'reel:view',
        ];

        $playlist_permissions = [
            'video:view',
            'video:add',

            'reel:view',
        ];

        $channel_permissions = [
            'video:view',
            'video:add',
            'video:update',

            'reel:view',
            'reel:add',
            'reel:update',

            
            'playlist:view',
            'playlist:add',
            'playlist:update',
        ];


        $manager_excluded_permissions = [
            'role:view',
            'role:add',
            'role:update',

            'tasks:responsible',
        ];
        foreach($roles as $role)
        { 
            Role::create([
                'name' => $role
            ]);
        }

        $role_a = Role::find(1);
        $role_m = Role::find(2);
        $role_u = Role::find(3);
        $role_author = Role::find(4);
        $role_playlist = Role::find(5);
        $role_channel = Role::find(6);

        foreach(Permission::all() as $permission)
        { 
            $role_a->givePermissionTo($permission->name);

            // Assign permissions to Manager
            if (!in_array($permission->name, $manager_excluded_permissions)) {
                $role_m->givePermissionTo($permission->name);
            }

            // Assign permissions to user
            if (!in_array($permission->name, $user_excluded_permissions)) {
                $role_u->givePermissionTo($permission->name);
            }
            
            if (in_array($permission->name, $author_permissions)) {
                $role_author->givePermissionTo($permission->name);
            }
            if (in_array($permission->name, $playlist_permissions)) {
                $role_playlist->givePermissionTo($permission->name);
            }
            if (in_array($permission->name, $channel_permissions)) {
                $role_channel->givePermissionTo($permission->name);
            }
        }     
    }
}
