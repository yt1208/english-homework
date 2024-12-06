<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homework extends Model {
    protected $guarded = ['id'];
    protected $table = 'homeworks';

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}