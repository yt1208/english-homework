<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vocabulary;
use Illuminate\Support\Facades\Auth;

class VocabularyController extends Controller
{
    public function index()
    {
        $vocabularies = Auth::user()->vocabularies ?? [];

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

        $vocabulary = Vocabulary::create([
            'word' => $request->word,
            'meaning' => $request->meaning,
            'user_id' => Auth::id(),
        ]);

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
       
        $vocabulary->update([
            'word' => $request->word,
            'meaning' => $request->meaning,
        ]);
       
        return redirect()->route('vocabularies.index')->with('success', '英単語を更新しました。');
    }

    public function destroy($id)
    {
        $vocabulary = Vocabulary::find($id);
    
        if ($vocabulary) {
            $vocabulary->delete();
        }
    
        return redirect()->route('vocabularies.index');
    }

}