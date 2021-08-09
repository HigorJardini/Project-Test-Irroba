<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Laratrust\LaratrustFacade as Laratrust;

class RequestUpdateUser extends FormRequest
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
        if(Laratrust::isAbleTo('update-users-manage'))
            return true;
        else
            return false;
        
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255',
            'role'     => 'required',
            'status'   => 'required'
        ];
        
    }

    public function messages()
    {
        return [
            'required'  => 'O campo :attribute deve ser preenchido.',
            'min'       => 'O campo :attribute tem o minimo de :min caracteres',
            'max'       => 'O campo :attribute tem o limite de :max caracteres',
            'email'     => 'O campo :attribute não é um email valido'
        ];
    }
}
