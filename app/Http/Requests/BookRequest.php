<?php

namespace App\Http\Requests;

class BookRequest extends BaseRequest
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
            'name'        => 'required',
            'poster'      => 'string',
            'pages'       => 'integer',
            'genre'       => 'string',
            'is_read'     => 'bool',
            'in_progress' => 'bool'
        ];
    }

    public function messages()
    {
        return [
            'name.required'    => 'Введите название книги',
            'pages.integer'    => 'Кол-во страниц должно быть числом',
            'genre.string'     => 'Жанр должен быть строкой'
        ];
    }
}
