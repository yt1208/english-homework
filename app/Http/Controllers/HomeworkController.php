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
        $homeworks = $this->homework->getHomeworksById($user->id);
        return view('homework.index', [
            'homeworks' => $homeworks,
        ]);
   
    }

    public function create()
    {
        $subjects = $this->homework->getAllSubjects();
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

        $userId = Auth::id();  

        $homework = [
            'title' => $request->title,
            'deadline' => $request->deadline,
            'user_id' => $userId,
            'subject_id' => $request->subject_id,
        ];

        $this->homework->storeHomework($homework);
 
        return redirect('/homeworks')->with('success', '宿題が作成されました！');
    }

    public function edit(Homework $homework)
    {
        $subjects = $this->homework->getAllSubjects();
    
        return view('homework.edit', [
            'subjects' => $subjects,
            'homework' => $homework,
        ]);
    }

    public function update(Request $request, Homework $homework)

    {
        $request->validate([
            'title' => 'required|string|max:100',
            'deadline' => 'required|date',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $data = [
            'title' => $request->title,
            'deadline' => $request->deadline,
            'subject_id' => $request->subject_id,
        ];

        $this->homework->updateHomework($homework, $data);
       
        return redirect('/homeworks')->with('success', '宿題が修正されました！');
    }    

    public function destroy($id)
    {
        $isDeleted = $this->homework->deleteHomework($id);
    
        if ($isDeleted) {
            return redirect('/homeworks')->with('success', '宿題を削除しました。');
        } else {
            return redirect('/homeworks')->with('error', '削除に失敗しました。');
        }
        
    }

}

