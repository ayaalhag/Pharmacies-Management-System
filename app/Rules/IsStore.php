<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;

class IsStore implements Rule
{
    private $attribute;

    public function __construct($attribute)
    {
        $this->attribute = $attribute;
    }

    public function passes($attribute, $value)
    {
        $user = User::find($value);
        return $user && $user->rule == 'store';
    }

    public function message()
    {
        return 'The ' . $this->attribute . ' must have the rule store.';
    }
}