<?php

use Illuminate\Database\Seeder;
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
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $role = Role::create(['name' => 'user', 'discord_id' => '442805547096342529']);
        $role = Role::create(['name' => 'beta-tester', 'discord_id' => '486250832178839563']);
        $role = Role::create(['name' => 'admin', 'discord_id' => '440550777912819712']);
        $role = Role::create(['name' => 'new', 'discord_id' => '692075680942522429']);
    }
}
