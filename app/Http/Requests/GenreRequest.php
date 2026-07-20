<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class GenreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $method = $this->method();

        if ($method === 'POST') {
            return [
                'name' => 'required|unique:genres,name',
                'is_active' => 'nullable|boolean',
                'slug' => 'required|unique:genres,slug',
                'description' => 'nullable|string',
            ];
        }elseif ($method === 'PUT') {
            return [
                'name',
                'is_active',
                'slug',
                'description',
            ];
        }

        throw new BadRequestHttpException();
    }
}
