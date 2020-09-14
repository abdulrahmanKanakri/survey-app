<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyUser;
use App\Models\UserAnswers;
use App\Repositories\Survey\ISurveyRepository;
use App\Repositories\User\IUserRepository;
use App\Requests\SurveyRequest;
use App\Services\SurveyService;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    private $dir = 'dashboard.survey.';
    private $surveyRepo;
    private $userRepo;
    private $surveyService;

    public function __construct(
        ISurveyRepository $surveyRepo, 
        IUserRepository $userRepo,
        SurveyService $surveyService
    ) {
        $this->surveyRepo = $surveyRepo;
        $this->userRepo = $userRepo;
        $this->surveyService = $surveyService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $surveys = $this->surveyRepo->getSurveys(15);
        return view($this->dir . 'index', compact('surveys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Survey::TYPES;
        return view($this->dir . 'create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SurveyRequest $request)
    {
        $survey = $this->surveyRepo->create($request->all());
        return redirect()->route($this->dir . 'show', $survey->id)->with('status', [
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
        $survey = $this->surveyRepo->getSurveyById($id);
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
        $types = Survey::TYPES;
        $survey = $this->surveyRepo->getSurveyById($id);
        return view($this->dir . 'edit', compact('survey', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SurveyRequest $request, $id)
    {        
        $this->surveyRepo->update($request->all(), $id);
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
        $this->surveyRepo->delete($id);
        return redirect()->route($this->dir . 'index')->with('status', [
            'type' => 'success',
            'msg' => 'Successfully deleted'
        ]);
    }

    public function assignToUsersPage(Survey $survey) {
        $users = $this->surveyService->getNotAssignedUsers($survey);
        return view($this->dir . 'assign', compact('survey', 'users'));
    }

    public function assignToUsers(Request $request, Survey $survey) {
        $this->surveyService->assignToUsers($survey, $request->users);
        return redirect()->route($this->dir . 'index')->with('status', [
            'type' => 'success',
            'msg' => 'Successfully deleted'
        ]);
    }
}
