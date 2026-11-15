<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CatalogFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'exists:categories,name'],
            'operation' => ['nullable', 'string', Rule::in(Product::OPERATIONS)],
            'sort' => ['nullable', 'string', Rule::in(['newest', 'price_asc', 'price_desc'])],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', Rule::in([9, 12, 24])],
        ];
    }

    public function messages(): array
    {
        return [
            'q.max' => 'Пошуковий запит не може перевищувати 100 символів.',
            'category.exists' => 'Обрана категорія не існує.',
            'operation.in' => 'Обрана операція недоступна.',
            'sort.in' => 'Неприпустимий спосіб сортування.',
            'page.integer' => 'Номер сторінки має бути цілим числом.',
            'page.min' => 'Номер сторінки має бути не меншим за 1.',
            'per_page.in' => 'Кількість записів на сторінці має бути 9, 12 або 24.',
        ];
    }
}
