<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Laratrust\LaratrustFacade as Laratrust;

class RequestMetter extends FormRequest
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
        if(Laratrust::isAbleTo('create-metters'))
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
            'name'      => 'required|string|max:255',
        ];
        
    }

    public function messages()
    {
        return [
            'required'  => 'O campo :attribute deve ser preenchido.',
            'min'       => 'O campo :attribute tem o minimo de :min',
            'max'       => 'O campo :attribute tem o limite de :max'
        ];
    }
}
