<?php

namespace App\Repositories\Answer;

interface IAnswerRepository {

    public function getAnswers($limit);
    
    public function getAnswerById($id);

    public function all();
    
    public function updateOrCreate($data, $id = null);
    
    public function delete($id);

}
