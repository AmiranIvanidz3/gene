<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class AddNewPermissions extends Migration
{
    public function up()
    {
        // Add new permissions
        Permission::create(['name' => 'permission:view']);
        Permission::create(['name' => 'permission:add']);
        Permission::create(['name' => 'permission:update']);
        Permission::create(['name' => 'reel:update-status']);
        // Add more permissions as needed
    }

    
 

    public function down()
    {
        // Revert the changes (optional)
        Permission::where('name', 'permission:view')->delete();
        Permission::where('name', 'permission:add')->delete();
        Permission::where('name', 'permission:update')->delete();
        Permission::where('name', 'reel:update-status')->delete();
        // Remove more permissions if needed
    }
}
