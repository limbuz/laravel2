<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;

class SessionRequest extends BaseRequest
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
            'email'    => 'required|email',
            'password' => ['required', Password::min(self::MIN_PASSWORD_LENGTH)]
        ];
    }

    public function messages()
    {
        return [
            'email.required'       => 'Введите ваш email',
            'email.email'          => 'Неверная почта',
            'password.required'    => 'Введите пароль',
            'password.min'         => "Минимальная длина пароля " . self::MIN_PASSWORD_LENGTH
        ];
    }
}
