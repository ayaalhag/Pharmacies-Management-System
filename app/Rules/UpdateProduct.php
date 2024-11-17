<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Product;

class UpdateProduct implements Rule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate($attribute, $value, $parameters, $validator)
    {
        $rule = $this->passes($attribute, $value);
        if (!$rule) {
            $validator->errors()->add($attribute, $this->message());
        }
        return $rule;
    }
    private $attribute;
    private $user_id;

    public function __construct($attribute,$user_id)
    {
        $this->attribute = $attribute;
        $this->user_id = $user_id;
    }
    public function passes($attribute, $value)
    {
        $product = Product::findOrFail($value);
        return $product->user_id == $this->user_id;
  
    }

  
    public function message()
    {
        return 'The ' . $this->attribute . ' must be associated with the specified user ID.';
    }

}
