<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    private $permissions = [


        'user:view',
        'user:add',
        'user:update',

        'role:view',
        'role:add',
        'role:update',
    
        'author:view',
        'author:add',
        'author:update',

        'playlist:view',
        'playlist:add',
        'playlist:update',        

        'video:view',
        'video:add',
        'video:update',
        
        'reel:view',
        'reel:add',
        'reel:update',
        'reel:update-status',
        'reel:update-content',

        'platform:view',
        'platform:add',
        'platform:update',
        'platform:links',
  
        'account:view',
        'account:add',
        'account:update',

        'project:view',
        'project:add',
        'project:update',

        'log:view',
        
        'published:view',

        'permission:view',
        'permission:add',
        'permission:update',

        'comment:view',

        'parameter:view',
        'parameter:add',
        'parameter:update',

        'topic:view',
        'topic:add',
        'topic:update',
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach($this->permissions as $permission)
        {
            Permission::create(['name' => $permission]);
        }
    }
}
