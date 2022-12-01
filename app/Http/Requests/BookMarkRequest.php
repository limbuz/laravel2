<?php

namespace App\Http\Requests;

class BookMarkRequest extends BaseRequest
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
            'book_id'     => 'required|integer',
            'is_read'     => 'bool',
            'in_progress' => 'bool'
        ];
    }

    public function messages()
    {
        return [
            'book_id.required' => 'Книга не выбрана'
        ];
    }
}
