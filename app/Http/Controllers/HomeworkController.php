<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\Homework;
use Illuminate\Support\Facades\Auth;

class HomeworkController extends Controller
{
    public function index()
    {
    
    $user = Auth::user();
    $subjects = Subject::orderBy('name')->get();
    $homeworks = Homework::where('user_id', $user->id)
    ->orderBy('title')
    ->orderBy('deadline')
    ->get();

    return view('homework_list', [
        'subjects' => $subjects,
        'homeworks' => $homeworks,

    ]);
   
    }

}
