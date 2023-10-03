<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SignUpRequest extends FormRequest
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
            'user_name' => 'required|unique:users,user_name|min:3|max:50',
            'password' => 'required|min:8|max:100',
            'role' => 'required|in:customer,admin'
        ];
    }

    public function messages(): array {
        return [
            'user_name.required' => 'user_name is required'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->messages();
        $parsedErrors = [];

        foreach ($errors as $key => $error) {
            $parsedErrors[$key] = $error[0];
        }

        throw new HttpResponseException(response()->json([
            'status' => 'failed',
            'errors' => $parsedErrors,
            'message' => 'error occured while validating request body',
        ], 400 ));
    }
}