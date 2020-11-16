<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->hasRole('super-admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $edit = request()->input('_method') == 'put';
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                $edit ? '' : 'unique:admins,email'
            ],
            'password' => [
                $edit ? 'nullable' : 'required',
                'string', 
                'min:8'
            ],
        ];
    }
}
