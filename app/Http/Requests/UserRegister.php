<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UserRegister extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => 'required|regex:/^[A-Za-z\s-_]+$/',
            'lastname' => 'required|regex:/^[A-Za-z\s-_]+$/',
            'mobile' => 'required|numeric',
            'email' => 'required|email',
            'age' => 'required|numeric',
            'gender' => ['required',Rule::in(['m','f','o'])],
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'city' => 'required|regex:/^[A-Za-z\s-_]+$/',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->api(false, 'Validation errors', $validator->errors()->first()));
    }

    public function messages() //OPTIONAL
    {
        return [
            'firstname.required' => 'First Name is required',
            'firstname.regex' => 'First Name must have only alphabets',

            'lastname.required' => 'Last Name is required',
            'lastname.regex' => 'Last Name must have only alphabets',

            'mobile.required' => 'Mobile number is required',
            'mobile.numeric' => 'Mobile number must be numeric',

            'email.required' => 'Email is required',
            'email.email' => 'Email is not correct',

            'age.required' => 'Age is required',
            'age.numeric' => 'Age must be numeric',

            'gender.required' => 'Gender is required',

            'password.required' => 'Password is required',
            'confirm_password.required' => 'Confirm password is required',
            'confirm_password.same' => 'Confirm password must be same as password',

            'city.required' => 'City is required',
            'city.regex' => 'City must have only alphabets',
        ];
    }
}
