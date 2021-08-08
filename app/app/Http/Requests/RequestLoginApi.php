<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestLoginApi extends FormRequest
{

    private $question;

    public function __construct()
    {
    }

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
     * @return array
     */
    public function rules()
    {

        return [
            'email'    => 'required|string|email|max:255|exists:users',
            'password' => 'required|string|min:6'
        ];
        
    }

    public function messages()
    {
        return [
            'required'  => 'O campo :attribute deve ser preenchido.',
            'min'       => 'O campo :attribute tem o minimo de :min',
            'max'       => 'O campo :attribute tem o limite de :max',
            'email'     => 'O campo :attribute não é um email valido',
            'exists'    => 'O usuário não foi encontrado'
        ];
    }
}
