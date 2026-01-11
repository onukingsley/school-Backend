<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    /** @use HasFactory<\Database\Factories\TermFactory> */
    use HasFactory;

    /*protected $fillable = ['name','academic_session_id'];*/
    protected $fillable = ['name','current_term'];


    public function Attendance(){
        return $this->hasMany(Attendance::class);
    }
    public function StaffAttendance(){
        return $this->hasMany(StaffAttendance::class);
    }
    public function AcademicSession(){
        return $this->belongsTo(Session::class);
    }

    public function SchoolFees(){
        return $this->hasMany(SchoolFees::class);
    }

    public function Result(){
        return $this->hasMany(Results::class);
    }

    public function TimeTable(){
        return $this->hasMany(timetable::class);
    }

    public function Assignment(){
        return $this->hasMany(Assignment::class);
    }

    public function ExamTable(){
        return $this->hasMany(ExamTable::class);
    }
    public function Scheme(){
        return $this->hasMany(SchemeModel::class);
    }

}
