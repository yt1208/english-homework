<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Homework;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use App\Repositories\HomeworkRepository;
use App\Http\Requests\StoreHomeworkRequest;

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
    
    public function store(StoreHomeworkRequest $request)
    {
        $userId = Auth::id();  

        $homeworkData = [
            'title' => $request->title,
            'deadline' => $request->deadline,
            'user_id' => $userId,
            'subject_id' => $request->subject_id,
        ];

        $this->homework->storeHomework($homeworkData);
 
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

    public function update(StoreHomeworkRequest $request, Homework $homework)
    {
        $updateData = [
            'title' => $request->title,
            'deadline' => $request->deadline,
            'subject_id' => $request->subject_id,
        ];

        $this->homework->updateHomework($homework, $updateData);
       
        return redirect('/homeworks')->with('success', '宿題が修正されました！');
    }    

    public function destroy($id)
    {
        $this->homework->deleteHomework($id);
        
        return redirect('/homeworks')->with('success', '宿題を削除しました。');
    }

}

