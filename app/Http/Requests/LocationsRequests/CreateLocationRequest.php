<?php

namespace App\Http\Requests\LocationsRequests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateLocationRequest extends FormRequest
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
            'city' => 'required',
            'street' => 'required',
            'building' => 'required',
            'floor' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'city.required' => 'City is required',
            'street.required' => 'Street is required',
            'building.required' => 'Building is required',
            'floor.required' => 'Floor is required',
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
