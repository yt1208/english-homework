<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use CrudTrait;

    protected $table = 'admins';

    protected $guard = 'admin';

    protected $fillable = ['name', 'e-mail', 'password'];
    
    protected $hidden = [
        'password', 'remember_token',
    ];
}
