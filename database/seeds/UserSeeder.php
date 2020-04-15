<?php

use App\Models\Users\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\Users\UserNotification;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = Permission::create(['name' => 'apply to beta']);

        $user = User::create([
            'name'      => 'Admin User',
            'username'  => 'adminuser',
            'email'     => 'admin@multicrew.co.uk',
            'password'  => Hash::make('test')
        ]);
        $userNotifications = new UserNotification();
		$userNotifications->user_id = $user->id;
		$new_request = $userNotifications->new_request;
		$new_request['aircrafts'] = [];
		$new_request['airports'] = [];
		$userNotifications->new_request = $new_request;
        $userNotifications->save();
        $user->email_verified_at = Carbon::now();
        $user->assignRole('user');
        $user->assignRole('admin');
        $user->save();

        $user = User::create([
            'name'      => 'Beta User',
            'username'  => 'betauser',
            'email'     => 'beta@multicrew.co.uk',
            'password'  => Hash::make('test')
        ]);
        $userNotifications = new UserNotification();
		$userNotifications->user_id = $user->id;
		$new_request = $userNotifications->new_request;
		$new_request['aircrafts'] = [];
		$new_request['airports'] = [];
		$userNotifications->new_request = $new_request;
        $userNotifications->save();
        $user->email_verified_at = Carbon::now();
        $user->assignRole('user');
        $user->save();

        $user = User::create([
            'name'      => 'Test User',
            'username'  => 'testuser',
            'email'     => 'test@multicrew.co.uk',
            'password'  => Hash::make('test')
        ]);
        $userNotifications = new UserNotification();
		$userNotifications->user_id = $user->id;
		$new_request = $userNotifications->new_request;
		$new_request['aircrafts'] = [];
		$new_request['airports'] = [];
		$userNotifications->new_request = $new_request;
        $userNotifications->save();
        $user->email_verified_at = Carbon::now();
        $user->assignRole('new');
        $user->givePermissionTo('apply to beta');
        $user->save();
    }
}
