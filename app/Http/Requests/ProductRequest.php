<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
        $article = 'required|regex:/^[A-Za-z0-9]+$/|';

        if ($this->method() == 'PUT') {
            $article .= Rule::unique('products')->ignore($this->product->id);
        } else {
            $article .= 'unique:products';
        }

        $rules =  [
            'name' => 'required|min:10',
            'article' => $article,
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле "Название" является обязательным.',
            'name.min' => 'Поле "Название" должно содержать не менее 10 символов.',
            'article.required' => 'Поле "Артикул" является обязательным.',
            'article.regex' => 'Поле "Артикул" должно содержать только латинские символы и цифры.',
            'article.unique' => 'Значение поля "Артикул" должно быть уникальным.',
        ];
    }
}
