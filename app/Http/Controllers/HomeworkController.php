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
    $users = User::where('student_id', $user->student_id)->get();
    $subjects = Subject::orderBy('name')->get();
    $homeworks = Homework::where('user_id', $user->id)
    ->orderBy('title')
    ->orderBy('deadline')
    ->get();

    return view('homework_list', [
        'users' => $users,
        'subjects' => $subjects,
        'homeworks' => $homeworks,

    ]);
   
    }

}
