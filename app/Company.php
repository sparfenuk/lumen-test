<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'title',
        'phone',
        'description',
    ];


    public function users()
    {
        return $this->belongsToMany('App\User', 'user_company');
    }
}
