<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_admin = \App\Models\Role::create([
            'name' => 'super_admin',
            'display_name'=> 'super admin',
            'description' => 'can do anything in the project'
        ]);
        $super_user = \App\Models\Role::create([
            'name' => 'super_user',
            'display_name'=> 'super user',
            'description' => 'show and do tasks'
        ]);
    }
}
