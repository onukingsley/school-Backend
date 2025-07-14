<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class timetable extends Model
{
    /** @use HasFactory<\Database\Factories\TimetableFactory> */
    use HasFactory;

    protected $fillable = ['subject_title','class_type_id','subject_id','staff_id','term_id','academic_session_id','day_of_the_week','time_range'];

    public function casts(): array
    {
        return [
            'day_of_the_week' => 'array'
        ];
    }

    public function ClassType(){
        return $this->belongsTo(Class_type::class,'class_type_id');
    }
    public function Subject(){
        return $this->belongsTo(Subject::class);
    }
    public function Staff(){
        return $this->belongsTo(Staff::class);
    }
    public function Term(){
        return $this->belongsTo(Term::class);
    }
    public function AcademicSession(){
        return $this->belongsTo(Session::class);
    }

}
