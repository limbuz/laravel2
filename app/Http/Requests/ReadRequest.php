<?php

namespace App\Http\Requests;

class ReadRequest extends BaseRequest
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
            'book_id'    => 'integer',
            'pages'      => 'required|integer',
            'timestamp'  => 'integer'
        ];
    }

    public function messages()
    {
        return [
            'pages.required' => 'Введите количество страниц',
            'pages.integer'  => 'Количество страниц должно быть целым числом'
        ];
    }
}
