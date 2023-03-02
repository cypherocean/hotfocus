<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeleteCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules() {
        return [
            'id' => 'required',
            'comment_id' => 'required',
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
            'comment_id.required' => 'Please provide comment ID'
        ];
    }
}
