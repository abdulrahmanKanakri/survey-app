<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\SurveyEmployee;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SubmissionController extends Controller
{
    private $dir = 'dashboard.submission.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $surveyEmployees = SurveyEmployee::with(['employee', 'survey'])
            ->withCount('submissions')
            ->get();
        // return response()->json($surveyEmployees);
        return view($this->dir . 'index', compact('surveyEmployees'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $surveyEmployee = SurveyEmployee::with([
            'employee', 'survey', 'submissions.userAnswers'
        ])->find($id);
        // return response()->json($surveyEmployee);
        return view($this->dir . 'show', compact('surveyEmployee'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // public function exportSurveyByUser($survey_id, $user_id) {
    //     return Excel::download(
    //         new ResponsesViewExport($survey_id, $user_id), 
    //         'survey_' . $survey_id . '_' . $user_id . '.xlsx'
    //     );
    // }

    // public function exportSurvey($survey_id) {
    //     return Excel::download(new ResponsesViewExport($survey_id), 'survey_' . $survey_id . '.xlsx');
    // }

    // public function exportAllSurveys() {
    //     return Excel::download(new ResponsesViewExport, 'surveys.xlsx');
    // }
}
