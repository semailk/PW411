<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|max:255|min:2',
            'genre_id' => 'required|integer|exists:genres,id',
            'description' => 'nullable|max:1000|min:10',
            'start_age' => 'nullable|integer|between:0,18',
            'time' => 'required|integer',
            'issue' => 'required|integer|between:1900,2050',
            'actors' => 'required|array',
            'actors.*' => 'integer|exists:actors,id',
            'cover' => ['mimes:jpg,bmp,png,jpeg', 'max:4096']
        ];
    }

    public function messages(): array
    {
        return [
            // Title
            'title.required' => 'Название фильма обязательно для заполнения.',
            'title.max' => 'Название фильма не должно превышать 255 символов.',
            'title.min' => 'Название фильма должно содержать минимум 2 символа.',

            // Genre
            'genre_id.required' => 'Жанр обязательно должен быть выбран.',
            'genre_id.integer' => 'Жанр должен быть выбран из списка.',
            'genre_id.exists' => 'Выбранный жанр не существует в системе.',

            // Description
            'description.max' => 'Описание не должно превышать 1000 символов.',
            'description.min' => 'Описание должно содержать минимум 10 символов.',

            // Start Age
            'start_age.integer' => 'Возрастное ограничение должно быть целым числом.',
            'start_age.between' => 'Возрастное ограничение должно быть от 0 до 18 лет.',

            // Time (длительность)
            'time.required' => 'Длительность фильма обязательна для заполнения.',
            'time.integer' => 'Длительность фильма должна быть указана в минутах (целое число).',

            // Issue (год выпуска)
            'issue.required' => 'Год выпуска фильма обязателен для заполнения.',
            'issue.integer' => 'Год выпуска должен быть указан числом.',
            'issue.between' => 'Год выпуска должен быть в диапазоне от 1900 до 2050 года.',

            // Actors
            'actors.required' => 'Необходимо выбрать хотя бы одного актера.',
            'actors.array' => 'Список актеров должен быть массивом.',
            'actors.*.integer' => 'ID актера должен быть целым числом.',
            'actors.*.exists' => 'Один из выбранных актеров не существует в системе.',

            // Cover
            'cover.mimes' => 'Обложка должна быть в одном из форматов: JPG, BMP, PNG или JPEG.',
            'cover.max' => 'Размер обложки не должен превышать 4 МБ.',
        ];
    }
}
