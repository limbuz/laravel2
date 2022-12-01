<?php

namespace App\Http\Requests;

class BookSearchRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'query' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'query.required' => 'Введите название книги',
            'query.string'   => 'Название книги должно быть строкой'
        ];
    }
}
