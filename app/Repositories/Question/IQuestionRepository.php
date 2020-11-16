<?php

namespace App\Repositories\Question;

interface IQuestionRepository {

    public function getQuestions($limit);
    
    public function getQuestionById($id);

    public function getTypes();

    public function all();
    
    public function updateOrCreate($data, $id = null);
    
    public function delete($id);

}
