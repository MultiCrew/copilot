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

        Role::create(['name' => 'admin', 'discord_id' => '440550777912819712']);
        Role::create(['name' => 'user', 'discord_id' => '442805547096342529']);
        Role::create(['name' => 'new', 'discord_id' => '692075680942522429']);

        Permission::create(['name' => 'apply to beta']);
    }
}
