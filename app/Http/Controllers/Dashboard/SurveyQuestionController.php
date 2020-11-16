<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Survey;
use App\Repositories\Answer\IAnswerRepository;
use App\Repositories\Question\IQuestionRepository;
use App\Repositories\Survey\ISurveyRepository;
use App\Requests\QuestionAnswerRequest;
use App\Services\QuestionService;
use Illuminate\Http\Request;

class SurveyQuestionController extends Controller
{
    private $dir = 'dashboard.survey.';
    private $dirQu = 'dashboard.survey.questions.';
    private $surveyRepo;
    private $questionRepo;
    private $answerRepo;
    private $questionService;

    public function __construct(
        ISurveyRepository $surveyRepo,
        IQuestionRepository $questionRepo,
        IAnswerRepository $answerRepo,
        QuestionService $questionService
    ) {
        $this->surveyRepo = $surveyRepo;
        $this->questionRepo = $questionRepo;
        $this->answerRepo = $answerRepo;
        $this->questionService = $questionService;
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $survey = $this->surveyRepo->getSurveyById($id);
        $types = $this->questionRepo->getTypes();
        return view($this->dirQu . 'create', compact('survey', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\Survey  $id 
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionAnswerRequest $request, Survey $survey)
    {
        $mappedData = $this->questionService->getMappedQuestion(
            $request->validated(), 
            $survey->id
        );
        $question = $this->questionRepo->updateOrCreate($mappedData);

        if($request->answers) {
            foreach($request->answers as $body) {
                $this->answerRepo->updateOrCreate([
                    'question_id' => $question->id,
                    'body' => $body
                ]);
            }
        }

        return redirect()->route($this->dir . 'show', $survey->id)->with('status', [
            'type' => 'success',
            'msg' => 'Successfully created'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Survey $survey, Question $question)
    {
        $types = $this->questionRepo->getTypes();
        return view($this->dirQu . 'edit', compact('question', 'survey', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionAnswerRequest $request, Survey $survey, Question $question)
    {
        $mappedData = $this->questionService->getMappedQuestion(
            $request->validated(), 
            $survey->id
        );
        $this->questionRepo->updateOrCreate($mappedData, $question->id);
        
        foreach($request->answers as $answer) {
            $this->answerRepo->updateOrdering($answer['ordering'], $answer['id']);
        }

        return redirect()->route($this->dir . 'show', $survey->id)->with('status', [
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
    public function destroy(Survey $survey, Question $question)
    {
        $this->questionRepo->delete($question->id);
        return redirect()->route($this->dir . 'show', $survey->id)->with('status', [
            'type' => 'success',
            'msg' => 'Successfully deleted'
        ]);
    }
}
