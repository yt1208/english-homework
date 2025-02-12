<?php

namespace App\Repositories;

use App\Models\Homework;
use App\Models\Subject;

class HomeworkRepository
{
    public function getHomeworksById(int $user_id)
    {
        $homeworks = Homework::where('user_id', $user_id)
        ->orderBy('title')
        ->orderBy('deadline')
        ->get();
        
        return $homeworks;
    }

    public function getAllSubjects()
    {
        return Subject::all();
    }

    public function storeHomework(array $homework)
    {
        return Homework::create($homework);
    }

    public function updateHomework(Homework $homework, array $data)
    {
        return $homework->update($data);
    }

    public function deleteHomework($id)
    {
    $homework = Homework::find($id);
    
    if ($homework) {
        return $homework->delete();
    }
    
    return false;
}

}