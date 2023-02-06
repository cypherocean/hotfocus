<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class MakePostRequest extends FormRequest {
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
            'id' => 'required',
            'file' => 'required',
            'post_type' => 'required',
            'media_type' => 'required'
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
            'id.required' => 'Please provide User ID',
            'file.required' => 'Please Upload Media',
            'post_type.required' => 'Please provide type of post',
            'media_type.required' => 'Please provide type of media',
        ];
    }
}
