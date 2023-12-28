<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use  App\Models\User;


class IsPharmacist implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        
    }
    public function passes($attribute, $value)
    {
     $user = User::find($value);
     return $user && $user->hasRule('pharmacist');
    }
    
    public function message()
    {
     return 'The :attribute must have the rule pharmacist';
    }
}
