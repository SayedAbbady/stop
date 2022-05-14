<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class students extends Model
{
    use SoftDeletes;

    protected $table = 'students';
    protected $guarded =[];

    public function parent()
    {
        return $this->belongsTo('App\Models\newStudent','parent_id')->withTrashed();
    }

    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher','teacher_id');

    }



}
