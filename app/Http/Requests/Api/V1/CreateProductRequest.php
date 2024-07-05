<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $url_rule = ['required', function ($attribute, $value, $fail) {
            if (!filter_var($value, FILTER_VALIDATE_URL)) {
                $fail("$attribute is not a valid URL.");
            }
        }];
        return [
            'entity_id' => 'required|integer|unique:products,entity_id',
            'category_name' => 'required',
            'sku' => 'required|max:50|unique:products,sku',
            'name' => 'required',
            'price' => 'required|numeric',
            'link' => $url_rule,
            'image' => $url_rule,
            'brand' => 'required',
            'rating' => 'nullable|integer|max:5',
            'caffeine_type' => 'nullable|max:50',
            'count' => 'nullable|integer'
        ];
    }
}
