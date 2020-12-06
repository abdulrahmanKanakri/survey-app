<?php

namespace App\Requests;

use App\Rules\GenderRule;
use App\Rules\MaritalStatusRule;
use App\Rules\NationalityRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'gender'         => ['required', new GenderRule],
            'age'            => ['required', 'numeric'],
            'birth_date'     => ['required', 'date'],
            'address'        => ['required', 'string'],
            'nationality'    => ['required', new NationalityRule],
            'marital_status' => ['required', new MaritalStatusRule],
        ];
    }
}
