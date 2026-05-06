<?php

namespace App\Http\Requests\BannersRequests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateBannerRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id',
            'category_id' => 'required|exists:categories,id',
            'name_en' => 'required',
            'name_ar' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Product is required',
            'product_id.exists' => 'Product not exists',
            'category_id.required' => 'Category is required',
            'category_id.exists' => 'Category not exists',
            'name_en.required' => 'English name is required',
            'name_ar.required' => 'Arabic name is required',
            'start_date.required' => 'Start date is required',
            'start_date.date' => 'Start date is invalid',
            'end_date.required' => 'End date is required',
            'end_date.date' => 'End date is invalid',
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
