<?php

namespace App\Rules;

use Illuminate\Support\Facades\Auth;
use App\Models\Users\UserNotification;
use Illuminate\Contracts\Validation\Rule;

class RequiredNotification implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $arr = explode('_', $attribute);
        unset($arr[2]);
        $str = implode('_', $arr);

        $requiredSetting = UserNotification::where($str, '1')->where('id', Auth::id())->first();

        if($requiredSetting != null) {
            return true;
        } else {
            return false;
        }; 
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute is required';
    }
}
