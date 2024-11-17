<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;


class ExpirationDate implements Rule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        
    }
    private $attribute;

    public function __construct($attribute)
    {
        $this->attribute = $attribute;
    }
    public function passes($attribute, $value)
    {
        if (!isset($value) || !is_string($value)) {
            return false;
        }

        $currentDate = date('Y-m-d');
        $futureDate = date('Y-m-d', strtotime('+1 month', strtotime($currentDate)));    
        return $value >= $futureDate;
    }

    public function message()
    {
        return 'The ' . $this->attribute . ' must have a date that is exactly one month from the current date.';  
    }
}
