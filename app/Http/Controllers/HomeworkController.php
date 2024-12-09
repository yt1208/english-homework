<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Homework;
use App\Models\Subject;
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

    public function create()
    {
        return view('homework.create');
    }
    
    public function store(Request $request)
    {
        $subject = Subject::firstOrCreate(['name' => $request->name]);
        $homework = new Homework();
        $homework->title = $request->title;
        $homework->deadline = $request->deadline;
        $homework->user_id = Auth::id();
        $homework->subject()->associate($subject);
        $homework->save();
 
        return redirect('/homeworks')->with('success', '宿題が作成されました！');
    }
}
