<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Homework;
use Illuminate\Support\Facades\Auth;

class HomeworkController extends Controller
{
    public function index()
    {
    
        $user = Auth::user();
        $homeworks = Homework::where('user_id', $user->id)
        ->orderBy('title')
        ->orderBy('deadline')
        ->get();

        return view('homework.index', [
            'homeworks' => $homeworks,

        ]);
   
    }

}
