<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    /** @use HasFactory<\Database\Factories\AssignmentFactory> */
    use HasFactory;

    protected $fillable = ['subject_id','class_type_id','title','content','due_date','term_id','academic_session_id', 'assignment_status'];

    public function Subject(){
        return $this->belongsTo(Subject::class);
    }

    public function ClassType(){
        return $this->belongsTo(ClassType::class);
    }

    public function term(){
        return $this->belongsTo(Term::class);
    }
    public function academicSession(){
        return $this->belongsTo(Session::class);
    }


}
