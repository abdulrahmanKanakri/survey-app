<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionAnswerRequest extends FormRequest
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
        $edit = strpos(url()->previous(), '/edit') >= 0;

        return [
            'question_title' => 'required',
            'question_type' => 'required',
            'question_required' => 'required',
            'based_question' => 'nullable',
            'based_answer' => 'nullable',
            'answers' => $edit ? 'nullable' : ['required', 'array'],
            'answers.*' => $edit ? 'nullable' : 'required'
        ];
    }
}
