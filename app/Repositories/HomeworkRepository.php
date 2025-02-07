<?php

namespace App\Repositories;

use App\Models\Homework;

class HomeworkRepository
{
    public function getHomeworksByid(int $user_id)
    {
        $homeworks = Homework::where('user_id', $user_id)
        ->orderBy('title')
        ->orderBy('deadline')
        ->get();
        
        return $homeworks;
    }
}