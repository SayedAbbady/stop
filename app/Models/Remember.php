<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Remember extends Model
{
    use SoftDeletes;

    protected $table = 'remembers';
    protected $guarded =[];
    // protected $dates = ['date'];


    public function admin()
    {
        return $this->belongsTo('App\User','admin_id');
    }

    public function students_remember()
    {
        return $this->belongsTo('App\Models\newStudent','student_id')->withTrashed();
    }
}
