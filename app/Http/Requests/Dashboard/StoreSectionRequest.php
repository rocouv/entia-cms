<?php

namespace App\Http\Requests\Dashboard;

use App\Models\Section;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'sort_order' => $this->input('sort_order', 0),
        ]);
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', Rule::in(array_keys(Section::TYPES))],
            'content' => ['nullable', 'array'],
            'content.title' => ['nullable', 'string', 'max:255'],
            'content.subtitle' => ['nullable', 'string', 'max:500'],
            'content.body' => ['nullable', 'string'],
            'content.image' => ['nullable', 'string', 'max:1000'],
            'content.image_position' => ['nullable', 'string', Rule::in(['left', 'right'])],
            'content.button_text' => ['nullable', 'string', 'max:255'],
            'content.button_url' => ['nullable', 'string', 'max:1000'],
            'content.category_id' => ['nullable', 'integer', 'min:1'],
            'content.limit' => ['nullable', 'integer', 'min:1', 'max:24'],
            'content.show_form' => ['nullable', 'boolean'],
            'content.items' => ['nullable', 'array'],
            'content.items.*.icon' => ['nullable', 'string', 'max:255'],
            'content.items.*.title' => ['nullable', 'string', 'max:255'],
            'content.items.*.description' => ['nullable', 'string', 'max:1000'],
            'content.items.*.question' => ['nullable', 'string', 'max:255'],
            'content.items.*.answer' => ['nullable', 'string', 'max:1000'],
            'content.images' => ['nullable', 'array'],
            'content.images.*.selected' => ['nullable', 'boolean'],
            'content.images.*.url' => ['nullable', 'string', 'max:1000'],
            'content.images.*.alt' => ['nullable', 'string', 'max:255'],
            'content_title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'content_body' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:1000'],
            'image_position' => ['nullable', 'string', Rule::in(['left', 'right'])],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_url' => ['nullable', 'string', 'max:1000'],
            'items_text' => ['nullable', 'string'],
            'category_id' => ['nullable', 'integer', 'min:1'],
            'limit' => ['nullable', 'integer', 'min:1', 'max:24'],
            'show_form' => ['nullable', 'boolean'],
            'variant' => ['nullable', 'string', 'max:255'],
            'spacing' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
        ];
    }
}
