<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model {
    protected $guarded = ['id'];

    public function homework() {
        return $this->hasOne(Homework::class);
    }
}
