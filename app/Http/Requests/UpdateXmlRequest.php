<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateXmlRequest extends FormRequest
{

    protected $entity_id;

    public function __construct($entity_id)
    {
        $this->entity_id = $entity_id;
    }

    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'entity_id' => ['required', 'integer'],
            'category_name' => ['required'],
            'sku' => ['required', 'max:50', Rule::unique('products', 'sku')->ignore($this->entity_id, 'entity_id')],
            'name' => ['required'],
            'price' => ['required', 'numeric'],
            'link' => ['required', function ($attribute, $value, $fail) {

                if (!filter_var($value, FILTER_VALIDATE_URL)) {
                    $fail("$attribute is not a valid URL.");
                }
            }],
            'image' => ['required', function ($attribute, $value, $fail) {
                if (!filter_var($value, FILTER_VALIDATE_URL)) {
                    $fail("$attribute is not a valid URL.");
                }
            }],
            'brand' => ['required'],
            'rating' => ['nullable', 'integer', 'max:5'],
            'caffeine_type' => ['nullable', 'max:50'],
            'count' => ['nullable', 'integer']
        ];
    }
}
