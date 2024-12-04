<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\Homework;

class HomeworkController extends Controller
{
    public function index()
    {
    $subjects = Subject::orderBy('name')->get();
    $homeworks = Homework::orderBy('title', 'deadline')->get();

    return view('homework_list', [
        'subjects' => $subjects,
        'homeworks' => $homeworks,

    ]);
   
    }

}
