<?php

namespace App\Repositories\Survey;

interface ISurveyRepository {

    public function getSurveys($limit);
    
    public function getSurveyById($id);

    public function all();
    
    public function create($data);
    
    public function update($data, $id);
    
    public function delete($id);

}
