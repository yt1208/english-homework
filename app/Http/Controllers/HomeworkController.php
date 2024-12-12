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
        $subjects = Subject::all();
        return view('homework.create', [
            'subjects' => $subjects ,

        ]);
        
    }
    
    public function store(Request $request)
    {
        $homework = new Homework();
        $homework->title = $request->title;
        $homework->deadline = $request->deadline;
        $homework->user_id = Auth::id();
        $homework->subject_id = $request->subject_id;
        $homework->save();
 
        return redirect('/homeworks')->with('success', '宿題が作成されました！');
    }

    public function edit(Homework $homework)
    {
        $subjects = Subject::all();
    
        return view('homework.edit', [
            'subjects' => $subjects,
            'homework' => $homework,
        ]);
    }

    public function update(Request $request, $id)

    {
        $homework = Homework::findOrFail($id); 
        $homework->update([
            'title' => $request->title,
            'deadline' => $request->deadline,
            'subject_id' => $request->subject_id,
        ]);
       
        return redirect('/homeworks')->with('success', '宿題が修正されました！');
    }
    
    public function destroyPage($id)
    {
        $homework = Homework::find($id);
        return view('homework.destroy', [
            "homework" => $homework
        ]);
    }
    

    public function destroy($id)
    {
        $homework = Homework::find($id);
    
        if ($homework) {
            $homework->delete();
        }
    
        return redirect('/homeworks')->with('success', '宿題を削除しました。');
    }

}

