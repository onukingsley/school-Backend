<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder\Class_;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

    protected $fillable = ['user_id','guardian_id', 'class_type_id','role','academic_average','academic_session_id'];


    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Guardian(){
        return $this->belongsTo(Guardian::class);
    }

    public function ClassType(){
        return $this->belongsTo(Class_type::class);
    }

    public function AcademicSession(){
        return $this->belongsTo(Session::class);
    }



    public function Attendance(){
        return $this->hasMany(Attendance::class);
    }

    public function Schoolfees(){
        return $this->hasMany(SchoolFees::class);
    }

    public function Result(){
        return $this->hasMany(Results::class);
    }

    public function ResultCheck(){
        return $this->hasMany(ResultsCheck::class);
    }


}
