<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Homework;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use App\Repositories\HomeworkRepository;

class HomeworkController extends Controller
{
    public function __construct(HomeworkRepository $homeworkRepository)
    {
        $this->homework = $homeworkRepository;
    }

    public function index()
    {
        $user = Auth::user();
        $homeworks = $this->homework->getHomeworksByid($user->id);
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
        $request->validate([
            'title' => 'required|string|max:100',
            'deadline' => 'required|date',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $homework = Homework::create([
            'title' => $request->title,
            'deadline' => $request->deadline,
            'user_id' => Auth::id(),
            'subject_id' => $request->subject_id,
        ]);
 
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

    public function update(Request $request, Homework $homework)

    {
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
    
        return redirect('/homeworks')->with('success', '宿題を完了しました。');
    }

}

