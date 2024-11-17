<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ExpirationDate;
use App\Rules\IsStore;

class AddProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id'=>['required', 'numeric', new IsStore('user_id'), 'exists:users,id'],
           'scientific_name'=>'required|max:55|string',
           'commercial_name'=>'required|max:55|string',
           'manufacturer'=>'required|max:55|string',
           'price'=>'required|max:55|string',
           'quantity'=>'required|max:55|string',
          'expiration_date'=>new ExpirationDate('expiration_date'),
          'category_id'=>'exists:categories,id',
        ];
    }
    public function messages(): array
    {
        return [
        ] ;
    }
}
