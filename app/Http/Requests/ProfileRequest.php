<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;

class ProfileRequest extends BaseRequest
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
            'email'           => 'required|email',
            'password'        => ['required', Password::min(self::MIN_PASSWORD_LENGTH)],
            'name'            => 'required',
            'second_name'     => 'required',
            'need_pages'      => 'required|integer',
            'need_books'      => 'integer',
            'timestamp_start' => 'integer',
            'timestamp_end'   => 'integer'
        ];
    }

    public function messages()
    {
        return [
            'email.required'       => 'Введите ваш email',
            'email.email'          => 'Неверная почта',
            'password.required'    => 'Введите пароль',
            'password.min'         => "Минимальная длина пароля " . self::MIN_PASSWORD_LENGTH,
            'name.required'        => 'Введите имя',
            'second_name.required' => 'Введите фамилию',
            'need_pages.required'  => 'Введите количество страниц, которое вы хотите прочитать',
            'need_pages.integer'   => 'Количество страниц должно быть целым числом',
            'need_books.integer'   => 'Количество книг должно быть целым числом'
        ];
    }
}
