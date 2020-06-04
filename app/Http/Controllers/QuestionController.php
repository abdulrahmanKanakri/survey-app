<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    private $dir = 'dashboard.question.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::with('survey', 'answers')->paginate(10);
        return view($this->dir . 'index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $surveys = Survey::all();
        return view($this->dir . 'create', compact('surveys'));
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

        $question = new Question;
        $question->title = $request->title;
        $question->survey_id = $request->survey_id;
        $question->save();

        return redirect()->route('question.index')->with('status', [
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
        $question = Question::with('survey', 'answers')->find($id);
        $surveys = Survey::all();
        return view($this->dir . 'edit', compact('question', 'surveys'));
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
        
        $question = Question::find($id);
        $question->title = $request->title;
        $question->survey_id = $request->survey_id;
        $question->save();

        return redirect()->route('question.index')->with('status', [
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
        Question::find($id)->delete();
        return redirect()->route('question.index')->with('status', [
            'type' => 'success',
            'msg' => 'Successfully deleted'
        ]);
    }

    private function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'survey_id' => 'required|exists:surveys,id'
        ];
    }
}
