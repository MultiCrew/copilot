<?php

use App\Models\Users\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\Users\UserNotification;
use Carbon\Carbon;
use App\Models\Users\Profile;

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

        $this->makeUser('Admin User', 'adminuser', 'admin@multicrew.co.uk', 'test', ['admin', 'user']);
        $this->makeUser('Beta User', 'betauser', 'beta@multicrew.co.uk', 'test', ['user']);
        $this->makeUser('Test User', 'testuser', 'test@multicrew.co.uk', 'test', ['new']);
    }

    /**
     * Make a new user account
     *
     * @param  string     $name     Full name
     * @param  string     $username Username
     * @param  string     $email    Email address
     * @param  string     $password Password (to be hashed)
     * @param  array|null $roles    Roles to assign on creation
     *
     * @return null
     */
    private function makeUser($name, $username, $email, $password, array $roles = null)
    {
        $user = User::create([
            'name'      => $name,
            'username'  => $username,
            'email'     => $email,
            'password'  => Hash::make($password)
        ]);
        $user->email_verified_at = Carbon::now();

        foreach ($roles as $role) {
            $user->assignRole($role);
        }

        $profile = new Profile();
        $profile->fill([
            'name'      => $name,
            'username'  => $username
        ]);
        $profile->user_id = $user->id;
        $profile->save();

        $userNotifications = new UserNotification();
        $userNotifications->user_id = $user->id;
        $new_request = $userNotifications->new_request;
        $new_request['aircrafts'] = [];
        $new_request['airports'] = [];
        $userNotifications->new_request = $new_request;
        $userNotifications->save();

        $user->save();
    }
}
