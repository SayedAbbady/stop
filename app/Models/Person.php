<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use SoftDeletes;

    protected $table = 'people';
    protected $guarded =[];
    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category','type');
    }

}
