<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolFees extends Model
{
    /** @use HasFactory<\Database\Factories\SchoolFeesFactory> */
    use HasFactory;

    protected $fillable = ['student_id','dues_id','amount','name','academic_session_id','term_id','transaction_id'];

    public function Student(){
        return $this->belongsTo(Student::class);
    }

    public function Dues (){
        return $this->belongsTo(Dues::class);
    }

    public function AcademicSession(){
        return $this->belongsTo(Session::class);
    }

    public function Term(){
        return $this->belongsTo(Term::class);
    }


}

