<?php

namespace App\Repositories;

use App\Models\Vocabulary;

class VocabularyRepository
{
    public function getVocabulariesById(int $user_id)
    {
        return Vocabulary::where('user_id', $user_id)->get();
    }

    public function storeVocabulary(array $vocabularyData)
    {
        return Vocabulary::create($vocabularyData);
    }

    public function updateVocabulary(Vocabulary $vocabulary, array $updateData)
    {
        return $vocabulary->update($updateData);
    }

    public function deleteVocabulary($id)
    {
        
    $vocabulary = Vocabulary::find($id);
    
    if ($vocabulary) {
        return $vocabulary->delete();
    }
    
        return false;
    }

}