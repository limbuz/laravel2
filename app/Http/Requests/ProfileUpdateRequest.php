<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ProfileUpdateRequest extends FormRequest
{
    const MIN_PASSWORD_LENGTH = 8;

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
            'email'           => 'email',
            'password'        => Password::min(self::MIN_PASSWORD_LENGTH),
            'name'            => 'string',
            'second_name'     => 'string',
            'need_pages'      => 'integer',
            'need_books'      => 'integer',
            'timestamp_start' => 'integer',
            'timestamp_end'   => 'integer'
        ];
    }

    public function messages()
    {
        return [
            'email.email'          => 'Неверная почта',
            'password.min'         => "Минимальная длина пароля " . self::MIN_PASSWORD_LENGTH,
            'name.string'          => 'Имя должно быть строкой',
            'second_name.string'   => 'Фамилия должна быть строкой',
            'need_pages.integer'   => 'Количество страниц должно быть целым числом',
            'need_books.integer'   => 'Количество книг должно быть целым числом'
        ];
    }
}
