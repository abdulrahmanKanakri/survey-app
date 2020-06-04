<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SurveyController extends Controller
{
    private $dir = 'dashboard.survey.';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $surveys = Survey::with('questions')->paginate(10);
        return view($this->dir . 'index', compact('surveys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->dir . 'create');
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

        $survey = new Survey;
        $survey->title = $request->title;
        $survey->description = $request->description;
        $survey->save();

        return redirect()->route('survey.show', $survey->id)->with('status', [
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
        $survey = Survey::with('questions.answers')->find($id);
        return view($this->dir . 'show', compact('survey'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $survey = Survey::find($id);
        return view($this->dir . 'edit', compact('survey'));
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
        
        $survey = Survey::find($id);
        $survey->title = $request->title;
        $survey->description = $request->description;
        $survey->save();

        return redirect()->route('survey.index')->with('status', [
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
        Survey::find($id)->delete();
        return redirect()->route('survey.index')->with('status', [
            'type' => 'success',
            'msg' => 'Successfully deleted'
        ]);
    }

    private function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required'
        ];
    }

    public function createQuestion($id)
    {
        $survey = Survey::find($id);
        return view($this->dir . 'question-create', compact('survey'));
    }

    public function storeQuestion(Request $request, $id)
    {
        $question = new Question;
        $question->title = $request->question_title;
        $question->survey_id = $id;
        $question->save();

        foreach($request->answers as $_answer) {
            $answer = new Answer;
            $answer->body = $_answer['body'];
            $answer->type = $_answer['type'];
            $answer->question_id = $question->id;
            $answer->save();
        }

        return redirect()->route('survey.show', $id)->with('status', [
            'type' => 'success',
            'msg' => 'Successfully created'
        ]);
    }
}
