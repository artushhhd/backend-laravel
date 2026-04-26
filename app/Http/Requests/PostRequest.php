<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => ['required', 'string', 'max:1000'],
            'like'        => ['nullable', 'integer', 'min:0'],
            'img'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'comment'     => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'description.required' => 'Поле "Описание" не может быть пустым.',
            'img.image'            => 'Загруженный файл должен быть картинкой.',
            'img.max'              => 'Размер картинки не должен превышать 2 МБ.',
            'like.integer'         => 'Количество лайков должно быть числом.',
        ];
    }
}
