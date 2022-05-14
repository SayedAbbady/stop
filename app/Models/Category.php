<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Model
{
    use LogsActivity;

    protected $table = 'categories';
    protected $guarded =[];
    // protected static $recordEvents = ['deleted'];
    protected static $logName = 'Category';
    protected static $logAttributes = ['id','name'];
    protected static $logOnlyDirty = true;

    public function person()
    {
        return $this->hasMany('App\Models\Person','type');
    }
    public function newparent()
    {
        return $this->hasMany('App\Models\newStudent','type');
    }
}
