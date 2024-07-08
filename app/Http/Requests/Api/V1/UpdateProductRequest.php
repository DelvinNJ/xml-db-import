<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

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
        $isPUT = $this->isMethod('PUT') ?? false;

        $url_rule = $isPUT ? ['required', function ($attribute, $value, $fail) {
            if (!filter_var($value, FILTER_VALIDATE_URL)) {
                $fail("$attribute is not a valid URL.");
            }
        }] :
            ['required', 'sometimes', function ($attribute, $value, $fail) {
                if (!filter_var($value, FILTER_VALIDATE_URL)) {
                    $fail("$attribute is not a valid URL.");
                }
            }];

        return [
            'entity_id' =>  $isPUT ?  'required|integer|unique:products,entity_id' : 'sometimes|required|integer|unique:products,entity_id,' . $this->product->id,
            'category_name' => $isPUT ?  'required' : 'required|sometimes',
            'sku' => $isPUT ? 'required|max:50|unique:products,sku' : 'required|sometimes|max:50|unique:products,sku,' . $this->product->id,
            'name' => $isPUT ? 'required' : 'required|sometimes',
            'price' => $isPUT ? 'required|numeric' : 'required|sometimes|numeric',
            'link' => $url_rule,
            'image' => $url_rule,
            'brand' => $isPUT ?  'required' : 'required|sometimes',
            'rating' => 'nullable|integer|max:5',
            'caffeine_type' => 'nullable|max:50',
            'count' => 'nullable|integer'
        ];
    }
}
