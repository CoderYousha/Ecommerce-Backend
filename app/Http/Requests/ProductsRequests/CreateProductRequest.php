<?php

namespace App\Http\Requests\ProductsRequests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateProductRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'name_en' => 'required',
            'name_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'price' => 'required|numeric',
            'amount' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'Category is required',
            'category_id.exists' => 'Category not exists',
            'name_en.required' => 'English name is required',
            'name_ar.required' => 'Arabic name is required',
            'description_en.required' => 'English description is required',
            'description_ar.required' => 'Arabic description is required',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be numeric',
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount must be numeric',
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
