<?php

namespace App\Http\Requests\AuthenticationsRequests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProfileRequest extends FormRequest
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
            'phone' => 'required|numeric',
            'whatsapp_phone' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'Full name is required',
            'phone.required' => 'Phone is required',
            'phone.numeric' => 'Phone must be numeric',
            'whatsapp_phone.required' => 'Whatsapp Phone is required',
            'whatsapp_phone.numeric' => 'Whatsapp Phone must be numeric',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = [];

        foreach($validator->errors()->all() as $error){
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
