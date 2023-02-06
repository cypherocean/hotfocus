<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use stdClass;

class ValidateOTPRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'email' => 'bail|required|email',
            'otp' => 'bail|required|numeric|digits:4',
            'token' => 'bail|required'
        ];
    }

    public function messages() {
        return [
            'email.required' => 'Please enter email address',
            'email.email' => 'Please enter valid email address',
            'otp.required' => 'Please enter OTP',
            'otp.numeric' => 'Please enter valid OTP',
            'otp.digits' => 'Please enter only 4 digits OTP',
        ];
    }

    public function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'status' => 422,
            'message' => $validator->errors()->all()
        ]));
    }
}
