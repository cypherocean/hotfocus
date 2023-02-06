<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SocialAuthRequest extends FormRequest
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
    public function rules() {
        return [
            'uid' => 'required',
            'email' => 'required|email|unique:users,email',
        ];
    }
    
    public function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'status' => 422,
            'message' => $validator->errors()->all()
        ]));
    }

    public function messages() {
        return [
            'name.required' => 'Please enter user name',
            'email.required' => 'Please enter email address',
            'email.email' => 'Please enter valid email address',
            'email.unique' => 'This email address is already taken',
        ];
    }
}
