<?php

use App\Models\Users\User;
use App\Models\Users\Profile;
use Illuminate\Database\Seeder;
use App\Models\Users\UserNotification;

class UserAdditionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $users->each(function ($user) {
            if (!$user->userNotification) {
                $userNotifications = new UserNotification();
                $userNotifications->user_id = $user->id;
                $new_request = $userNotifications->new_request;
                $new_request['aircrafts'] = [];
                $new_request['airports'] = [];
                $userNotifications->new_request = $new_request;
                $userNotifications->save();
            }
            if (!$user->profile) {
                $profile = Profile::create([
                    'user_id' => $user->id
                ]);
                $profile->save();
            }
        });
    }
}
