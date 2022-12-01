<?php

namespace App\Http\Requests;

class ReadGetRequest extends BaseRequest
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
            'timestamp_start' => 'integer',
            'timestamp_end'   => 'integer',
            'book_id'         => 'integer',
            'genre'           => 'string'
        ];
    }

    public function messages()
    {
        return [
            'genre.string' => 'Жанр должен быть строкой'
        ];
    }
}
