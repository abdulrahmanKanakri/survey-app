<?php

namespace App\Http\Controllers;

use App\Repositories\Question\IQuestionRepository;
use App\Repositories\Survey\ISurveyRepository;
use App\Requests\QuestionRequest;

class QuestionController extends Controller
{
    private $dir = 'dashboard.question.';
    private $surveyRepo;
    private $questionRepo;

    public function __construct(
        ISurveyRepository $surveyRepo,
        IQuestionRepository $questionRepo
    ) {
        $this->surveyRepo = $surveyRepo;
        $this->questionRepo = $questionRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = $this->questionRepo->getQuestions(15);
        return view($this->dir . 'index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $surveys = $this->surveyRepo->all();
        return view($this->dir . 'create', compact('surveys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
        $this->questionRepo->updateOrCreate($request->all());
        return redirect()->route($this->dir . 'index')->with('status', [
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
        $question = $this->questionRepo->getQuestionById($id);
        $surveys = $this->surveyRepo->all();
        return view($this->dir . 'edit', compact('question', 'surveys'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionRequest $request, $id)
    {
        $this->questionRepo->updateOrCreate($request->all(), $id);
        return redirect()->route($this->dir . 'index')->with('status', [
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
        $this->questionRepo->delete($id);
        return redirect()->route($this->dir . 'index')->with('status', [
            'type' => 'success',
            'msg' => 'Successfully deleted'
        ]);
    }
}
