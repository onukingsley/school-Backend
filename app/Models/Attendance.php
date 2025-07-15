<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    /** @use HasFactory<\Database\Factories\AttendanceFactory> */
    use HasFactory;

    protected $fillable = ['student_id','class_type_id','attendance','academic_session_id','term_id'];

    public function casts(): array
    {
        return [
          'attendance'=> 'boolean'
        ];
    }

    public function Student(){
        return $this->belongsTo(Student::class);
    }

    public function ClassType(){
        return $this->belongsTo(Class_type::class);
    }

    public function AcademicSession(){
        return $this->belongsTo(Session::class);
    }

    public function Term(){
        return $this->belongsTo(Term::class);
    }
}
