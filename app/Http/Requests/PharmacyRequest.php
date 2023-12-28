<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password as Password_rule;
use Illuminate\Passport\Facades\Auth;
use  App\Rules\IsPharmacist;


class PharmacyRequest extends FormRequest
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
            'full_name' => 'required|max:55|string',
            'pharmacy_name' => 'required|max:55|string',
            'pharmacy_address' => 'required|max:55|string',
            'rule' => ['required','string',new IsPharmacist()],
            'phone' => 'required|string|digits:12|unique:users',
            'password' => ['required', 'confirmed',
             Password_rule::min(8)
             ->mixedCase()
             ->numbers()
             ->symbols()],
        ];
    }
    public function messages()
    {
        return [
            'full_name.required' => 'Full name filed is required',
            'full_name.max' => 'Full name should be less than 55 charecters',
            'full_name.string' => 'Full name should be string',
            'pharmacy_name.required'=>'Pharmacy Name filed is required',
            'pharmacy_name.max'=>'Pharmacy Name should be less than 55 charecters',
            'pharmacy_name.string'=>'Pharmacy Name should be string',
            'pharmacy_address.required'=>'Pharmacy Address filed is required',
            'pharmacy_address.max'=>'Pharmacy Address should be less than 55 charecters',
            'pharmacy_address.string'=>'Pharmacy Address should be string',
            'phone.required' => 'Phone filed is required',
            'phone.digits' => 'Phone should be 12 number',
            'password.required' => 'password filed is required',
        ];
    }
}
