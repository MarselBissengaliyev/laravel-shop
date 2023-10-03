<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|min:2|max:50',
            'description' => 'required|min:8|max:150',
            'price' => 'required',
            'picture_url' => 'required',
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
