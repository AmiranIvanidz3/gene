<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Author;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_a = Role::find(1);
        $role_m = Role::find(2);
        $role_u = Role::find(3);
        $role_author = Role::find(4);

        $admin = User::create([
            'name' => 'Admin',
            'last_name' => 'AdminLastName',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('11111111'),
        ]);

        $user = User::create([
            'name' => 'User',
            'last_name' => 'UserLastName',
            'email' => 'user@gmail.com',
            'password' => Hash::make('11111111'),
        ]);

        $manager = User::create([
            'name' => 'Manager',
            'last_name' => 'ManagerLastName',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('11111111'),
        ]);

        $author = User::create([
            'name' => 'Author',
            'last_name' => 'AuthorLastName',
            'email' => 'author@gmail.com',
            'password' => Hash::make('11111111')
        ]);

        $admin->assignRole($role_a);
        $user->assignRole($role_u);
        $manager->assignRole($role_m);
        $author->assignRole($role_author);

        
        // \App\Models\User::factory()->count(5)->create();



    }
}
