<?php

namespace App\Http\Requests\UsersRequests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUserRequest extends FormRequest
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
            'full_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric',
            'whatsapp_phone' => 'required|numeric',
            'password' => 'required|confirmed|min:8',
            'role' => 'required',
            'image' => 'nullable|image'

        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'Full name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Invalid email',
            'email.unique' => 'This email already used',
            'phone.required' => 'Phone is required',
            'phone.numeric' => 'Phone must be numeric',
            'whatsapp_phone.required' => 'Whatsapp Phone is required',
            'whatsapp_phone.numeric' => 'Whatsapp Phone must be numeric',
            'password.required' => 'Password is required',
            'password.confirmed' => 'Incorrect password confirmation',
            'password.min' => 'Password must be at least 8 characters',
            'role.required' => 'Role is required',
            'image.image' => 'Invalid image',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = [];

        foreach ($validator->errors()->all() as $error) {
            $errors[] = $error;
        }

        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'errors' => $errors
            ], 422)
        );
    }
}
