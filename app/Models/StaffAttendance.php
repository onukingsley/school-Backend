<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffAttendance extends Model
{
    protected $fillable = ['staff_id','attendance','academic_session','term_id'];


    public function Staff(){
        return $this->belongsTo(Staff::class,'staff_id');
    }

    public function Term(){
        return $this->belongsTo(Term::class,'term_id');
    }

    public function AcademicSession(){
        return $this->belongsTo(Session::class);
    }


}
