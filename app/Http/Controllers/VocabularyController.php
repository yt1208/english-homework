<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vocabulary;
use Illuminate\Support\Facades\Auth;
use App\Repositories\VocabularyRepository;

class VocabularyController extends Controller
{
    public function __construct(VocabularyRepository $vocabularyRepository)
    {
        $this->vocabulary = $vocabularyRepository;
    }

    public function index()
    {
        $user = Auth::user();
        $vocabularies = $this->vocabulary->getVocabulariesById($user->id);

        return view('vocabularies.index', [
            'vocabularies' => $vocabularies,

        ]);
    }

    public function create()
    {
        return view('vocabularies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'word' => 'required|string|max:100',
            'meaning' => 'required|string|max:100',
        ]);

        $userId = Auth::id();  

        $vocabularyData = [
            'word' => $request->word,
            'meaning' => $request->meaning,
            'user_id' => $userId,
        ];

        $this->vocabulary->storeVocabulary($vocabularyData);

        return redirect()->route('vocabularies.index')->with('success', '英単語を追加しました。');
    }

    public function edit(Vocabulary $vocabulary)
    {
        return view('vocabularies.edit', [
            'vocabulary' => $vocabulary,
        ]);
    }

    public function update(Request $request, Vocabulary $vocabulary)

    {
        $request->validate([
            'word' => 'required|string|max:100',
            'meaning' => 'required|string|max:100',
        ]);
       
        $updateData = [
            'word' => $request->word,
            'meaning' => $request->meaning,
        ];

        $this->vocabulary->updateVocabulary($vocabulary, $updateData);
       
        return redirect()->route('vocabularies.index')->with('success', '英単語を更新しました。');
    }

    public function destroy($id)
    {
        $isDeleted = $this->vocabulary->deleteVocabulary($id);

        if ($isDeleted) {
            return redirect('/vocabularies')->with('success', '英単語を削除しました。');
        } else {
            return redirect('/vocabularies')->with('error', '削除に失敗しました。');
        }
    }

}