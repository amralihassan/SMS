<?php

namespace Student\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Language extends Model
{
    use LogsActivity;

    protected $fillable = ['ar_name', 'en_name', 'sort', 'lang_type', 'admin_id'];

    protected static $logAttributes = ['ar_name', 'en_name', 'sort', 'lang_type'];

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin', 'admin_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('M d Y, D h:i a');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('M d Y, D h:i a');
    }

    public function scopeSort($query)
    {
        return $query->orderBy('sort', 'asc');
    }

    public function getLanguageNameAttribute()
    {
        return session('lang') == 'ar' ? $this->ar_name : $this->en_name;
    }

    public function getLangTypeAttribute($value)
    {
        switch ($value) {
            case 'speak':return trans('student::local.speak');
            case 'study':return trans('student::local.study');
            case 'speak_study':return trans('student::local.speak_study');

        }
    }
    public function scopeSpeak($query)
    {
        return $query->where('lang_type', '<>', 'study');
    }

    public function scopeStudy($query)
    {
        return $query->where('lang_type', '<>', 'speak');
    }
}
