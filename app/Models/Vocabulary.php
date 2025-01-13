<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    use HasFactory;

    protected $fillable = ['word', 'meaning','user_id'];
    
    public function user() {
        return $this->belongsTo(User::class);
    }

}
