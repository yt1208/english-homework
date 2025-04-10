<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrammarQuestion extends Model
{
    protected $table = 'grammar_questions';

    protected $fillable = [
        'question', 'option_1', 'option_2', 'option_3', 'option_4',
        'correct_option', 'unit_id'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}