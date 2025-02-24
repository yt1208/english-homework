<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vocabulary;
use Illuminate\Support\Facades\Auth;
use App\Repositories\VocabularyRepository;
use App\Http\Requests\StoreVocabularyRequest;

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

    public function store(StoreVocabularyRequest $request)
    {
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

    public function update(StoreVocabularyRequest $request, Vocabulary $vocabulary)

    {      
        $updateData = [
            'word' => $request->word,
            'meaning' => $request->meaning,
        ];

        $this->vocabulary->updateVocabulary($vocabulary, $updateData);
       
        return redirect()->route('vocabularies.index')->with('success', '英単語を更新しました。');
    }

    public function destroy($id)
    {
        $this->vocabulary->deleteVocabulary($id);

        return redirect('/vocabularies')->with('success', '英単語を削除しました。');
    }

}