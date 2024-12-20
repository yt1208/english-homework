<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model {
    protected $guarded = ['id'];
    public $timestamps = false;

    public function homework() {
        return $this->hasMany(Homework::class);
    }
}
