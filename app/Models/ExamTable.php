<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamTable extends Model
{
    /** @use HasFactory<\Database\Factories\ExamTableFactory> */
    use HasFactory;

    protected $fillable = ['class_type_id','academic_session_id','term_id', 'subject_id','staff_id','invigilator', 'time_range'];

    public function casts():array
    {
        return [
                'invigilator'=>'array'
            ];
    }

    public function ClassType(){
        return $this->belongsTo(Class_type::class);
    }

    public function Subject(){
        return $this->belongsTo(Subject::class);
    }

    public function Staff(){
        return $this->belongsTo(Staff::class);
    }
    public function AcademicSession(){
        return $this->belongsTo(Session::class);
    }
    public function Term(){
        return $this->belongsTo(Term::class);
    }

}
