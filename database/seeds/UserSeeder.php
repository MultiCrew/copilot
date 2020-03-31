<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;
use Spatie\Permission\Models\Role;
use App\Models\Users\UserNotification;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'      => 'Admin User',
            'username'  => 'adminuser',
            'email'     => 'admin@multicrew.co.uk',
            'password'  => Hash::make('test')
        ]);
        $userNotifications = new UserNotification();
        $userNotifications->user_id = $user->id;
        $userNotifications->save();
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
        $userNotifications->save();
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
        $userNotifications->save();
        $user->assignRole('new');
        $user->save();
    }
}
