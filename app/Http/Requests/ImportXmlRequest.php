<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportXmlRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            '*.entity_id' => ['required', 'integer', 'unique:products,entity_id'],
            '*.category_name' => ['required'],
            '*.sku' => ['required', 'max:50', 'unique:products,sku'],
            '*.name' => ['required'],
            '*.price' => ['required', 'numeric'],
            '*.link' => ['required', function ($attribute, $value, $fail) {

                if (!filter_var($value, FILTER_VALIDATE_URL)) {
                    $fail("$attribute is not a valid URL.");
                }
            }],
            '*.image' => ['required', function ($attribute, $value, $fail) {
                if (!filter_var($value, FILTER_VALIDATE_URL)) {
                    $fail("$attribute is not a valid URL.");
                }
            }],
            '*.brand' => ['required'],
            '*.rating' => ['nullable', 'integer', 'max:5'],
            '*.caffeine_type' => ['nullable', 'max:50'],
            '*.count' => ['nullable', 'integer']
        ];
    }
}
