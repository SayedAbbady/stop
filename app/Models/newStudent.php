<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class newStudent extends Model
{
    use SoftDeletes;

    use LogsActivity;
    protected static $logName = 'Students';
    protected static $logAttributes = ['id','parent_name','email','phone','status','type','responce','add_info'];
    protected static $logOnlyDirty = true;

    protected $table = 'new_students';
    protected $guarded =[];
    protected $dates = ['deleted_at'];


    public function children()
    {
        return $this->hasMany('App\Models\students','parent_id')->withTrashed();
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category','type');
    }

    public function remember_students()
    {
        return $this->hasMany('App\Models\Remember','student_id')->withTrashed();
    }

}
