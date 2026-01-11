<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchemeModel extends Model
{
    protected $fillable = ['week_id','description','title','subject_id','term_id'];

    public function Subject(){
        return $this->belongsTo(Subject::class);
    }

    public function Term(){
        return $this->belongsTo(Term::class);
    }
    public function Week(){
        return $this->belongsTo(WeekModel::class);
    }
}
