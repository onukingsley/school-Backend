<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Results extends Model
{
    /** @use HasFactory<\Database\Factories\ResultsFactory> */
    use HasFactory;

    protected $fillable = ['student_id','subject_id','class_type_id','term_id','academic_session_id','level','grade_scale_id','test1','test2','assignment1','assignment2','total','exam'];

    public function student (){
        return $this->belongsTo(Student::class);
    }

    public function subject (){
        return $this->belongsTo(Subject::class);
    }

    public function classType(){
        return $this->belongsTo(ClassType::class);
    }

    public function term(){
        return $this->belongsTo(Term::class);
    }


    public function gradeScale(){
        return $this->belongsTo(GradeScale::class);
    }

    public function academicSession (){
        return $this->belongsTo(Session::class);
    }


}
