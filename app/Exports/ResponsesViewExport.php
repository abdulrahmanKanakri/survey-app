<?php

namespace App\Exports;

use App\Models\ResponsesView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ResponsesViewExport implements FromCollection, WithHeadings, WithMapping
{

    private $survey_id;
    private $user_id;

    public function __construct($survey_id = null, $user_id = null)
    {
        $this->survey_id = $survey_id;
        $this->user_id = $user_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ResponsesView::
            when($this->survey_id, function ($query) {
                return $query->where('survey_id', $this->survey_id);
            })
            ->when($this->user_id, function ($query) {
                return $query->where('user_id', $this->user_id);
            })
            ->get();
    }

    public function headings(): array
    {
        return [
            "survey_id",
            "survey_title",
            "user_id",
            "username",
            "user_ip_address",
            "question_id",
            "question_title",
            "response",
            "dependent_question_id",
            "dependent_answer_id"
        ];
    }

    public function map($row): array
    {
        // This for spliting the values in json into rows
        $responses = [];
        if(!is_numeric($row->response) && isJson($row->response)) {
            $answers = json_decode($row->response);
            foreach($answers as $answer) {
                $responses[] = [
                    $row->survey_id,
                    $row->survey_title,
                    $row->user_id,
                    $row->username,
                    $row->user_ip_address,
                    $row->question_id,
                    $row->question_title,
                    $answer,
                    $row->dependent_question_id,
                    $row->dependent_answer_id
                ];
            }
            return $responses;
        } else {
            return $row->getAttributes();
        }
    }
}
