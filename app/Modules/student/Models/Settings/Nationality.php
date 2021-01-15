<?php

namespace Student\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Nationality extends Model
{
    use LogsActivity;

    protected $fillable = ['ar_male_name', 'ar_female_name', 'en_name', 'sort', 'admin_id'];

    protected static $logAttributes = ['ar_male_name', 'ar_female_name', 'en_name', 'sort'];

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

    public function getMaleNationalityAttribute()
    {
        return session('lang') == 'ar' ? $this->ar_male_name : $this->en_name;
    }

    public function getFemaleNationalityAttribute()
    {
        return session('lang') == 'ar' ? $this->ar_female_name : $this->en_name;
    }
}
