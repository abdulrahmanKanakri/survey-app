<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $edit = strpos(url()->previous(), 'edit') != false;

        return [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                !$edit ? 'unique:users,email' : ''
            ],
            'password' => !$edit ? 'required' : '',
            'role' => 'required',
        ];
    }
}
