<?php

namespace App\Http\Controllers;

use App\Repositories\Answer\IAnswerRepository;
use App\Repositories\Question\IQuestionRepository;
use App\Repositories\Survey\ISurveyRepository;
use App\Requests\AnswerRequest;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    private $dir = 'dashboard.answer.';
    private $surveyRepo;
    private $questionRepo;
    private $answerRepo;

    public function __construct(
        ISurveyRepository $surveyRepo,
        IQuestionRepository $questionRepo,
        IAnswerRepository $answerRepo
    ) {
        $this->surveyRepo = $surveyRepo;
        $this->questionRepo = $questionRepo;
        $this->answerRepo = $answerRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $answers = $this->answerRepo->getAnswers(15);
        return view($this->dir . 'index', compact('answers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $questions = $this->questionRepo->all();
        $types = $this->answerRepo->getTypes();
        return view($this->dir . 'create', compact('questions', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnswerRequest $request)
    {
        $this->answerRepo->updateOrCreate($request->all());
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
        $answer = $this->answerRepo->getAnswerById($id);
        $questions = $this->questionRepo->all();
        $types = $this->answerRepo->getTypes();
        return view($this->dir . 'edit', compact('answer', 'questions', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnswerRequest $request, $id)
    {
        $this->answerRepo->updateOrCreate($request->all(), $id);
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
        $this->answerRepo->delete($id);
        return redirect()->route($this->dir . 'index')->with('status', [
            'type' => 'success',
            'msg' => 'Successfully deleted'
        ]);
    }

    public function createAnswer(Request $request) {
        $answer = $this->answerRepo->updateOrCreate($request->all());
        return response()->json($answer);
    }

    public function cerateMultipleAnswers(Request $request) {
        $answers = [];
        foreach($request->answers as $answer) {
            $answers[] = $this->answerRepo->updateOrCreate([
                'body' => $answer['value'],
                'question_id' => $request->question_id
            ]);
        }
        return response()->json($answers);
    }

    public function editAnswer(Request $request, $id) {
        $answer = $this->answerRepo->updateOrCreate($request->all(), $id);
        return response()->json($answer);
    }

    public function deleteAnswer($id) {
        $this->answerRepo->delete($id);
        return response()->json([
            'success' => true,
            'msg' => 'Successfully deleted'
        ]);
    }

}
