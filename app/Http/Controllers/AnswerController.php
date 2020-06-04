<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Rules\AnswerType;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    private $dir = 'dashboard.answer.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $answers = Answer::with('question')->paginate(10);
        return view($this->dir . 'index', compact('answers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $questions = Question::all();
        $types = Answer::getTypes();
        return view($this->dir . 'create', compact('questions', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->rules());

        $answer = new Answer;
        $answer->body = $request->body;
        $answer->type = $request->type;
        $answer->question_id = $request->question_id;
        $answer->save();

        return redirect()->route('answer.index')->with('status', [
            'type' => 'success',
            'msg' => 'Successfully created'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $answer = Answer::with('question')->find($id);
        $questions = Question::all();
        $types = Answer::getTypes();
        return view($this->dir . 'edit', compact('answer', 'questions', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->rules());
        
        $answer = Answer::find($id);
        $answer->body = $request->body;
        $answer->type = $request->type;
        $answer->question_id = $request->question_id;
        $answer->save();

        return redirect()->route('answer.index')->with('status', [
            'type' => 'success',
            'msg' => 'Successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Answer::find($id)->delete();
        return redirect()->route('answer.index')->with('status', [
            'type' => 'success',
            'msg' => 'Successfully deleted'
        ]);
    }

    private function rules()
    {
        return [
            'body' => 'required',
            'type' => ['required', new AnswerType],
            'question_id' => 'required|exists:questions,id'
        ];
    }
}
