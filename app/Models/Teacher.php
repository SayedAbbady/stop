<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Teacher extends Model
{
    protected $table = 'teachers';
    protected $guarded =[];

    public function students()
    {
        return $this->hasMany('App\Models\students','teacher_id');
    }


}
