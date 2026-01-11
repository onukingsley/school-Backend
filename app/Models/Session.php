<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    /** @use HasFactory<\Database\Factories\SessionFactory> */
    use HasFactory;

    protected $fillable = ['year'];
    protected $table = 'academic_sessions';

    public function Student(){
        return $this->hasMany(Student::class);
    }

    public function Attendance(){
        return $this->hasMany(Attendance::class);
    }

    public function StaffAttendance(){
        return $this->hasMany(StaffAttendance::class);
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




}
