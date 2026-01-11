<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeekModel extends Model
{
    protected $fillable = ['wk','currentWeek'];

    public function Scheme(){
        return $this->hasMany(SchemeModel::class);
    }
}
