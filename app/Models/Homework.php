<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homework extends Model {
    protected $guarded = ['id'];
    protected $table = 'homeworks';
    protected $fillable = ['subject', 'title', 'deadline', 'user_id', 'subject_id'];

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    
    }
}