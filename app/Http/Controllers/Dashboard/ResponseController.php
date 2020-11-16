<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Exports\ResponsesViewExport;
use App\Models\SurveyUser;
use App\Models\UserAnswers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ResponseController extends Controller
{
    private $dir = 'dashboard.response.';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $surveyUsers = null;
        if($request->filters) {
            $surveyUsers = SurveyUser::
                when($request->filters['survey'], function ($q) use ($request) {
                    return $q->whereHas('survey', function ($builder) use ($request) {
                        return $builder->where('title', 'LIKE', '%'. $request->filters['survey'] .'%');
                    });
                })
                ->when($request->filters['username'], function ($q) use ($request) {
                    return $q->whereHas('user', function ($builder) use ($request) {
                        return $builder->where('name', 'LIKE', '%'. $request->filters['username'] .'%');
                    });
                })
                ->paginate(15);
        } else {
            $surveyUsers = SurveyUser::paginate(15);
        }
        
        return view($this->dir . 'index', compact('surveyUsers'));
        // return response()->json($surveyUser);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $surveyUser = SurveyUser::withAll()->find($id);
        return view($this->dir . 'show', compact('surveyUser'));
        // return response()->json($surveyUser);
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

    public function exportSurveyByUser($survey_id, $user_id) {
        return Excel::download(
            new ResponsesViewExport($survey_id, $user_id), 
            'survey_' . $survey_id . '_' . $user_id . '.xlsx'
        );
    }

    public function exportSurvey($survey_id) {
        return Excel::download(new ResponsesViewExport($survey_id), 'survey_' . $survey_id . '.xlsx');
    }

    public function exportAllSurveys() {
        return Excel::download(new ResponsesViewExport, 'surveys.xlsx');
    }
}
