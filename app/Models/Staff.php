<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    /** @use HasFactory<\Database\Factories\StaffFactory> */
    use HasFactory;

    protected $fillable = ['phone_no', 'account_no','form_teacher', 'subject','user_id','staff_role_id', 'dues_id' ];

    protected function casts(): array
    {
        return [
            'subject' => 'array',
            'form_teacher'=> 'boolean'
        ];
    }

    public function User(){
        return $this->belongsTo(User::class, 'user_id' );
    }

    public function Dues (){
        return $this->belongsTo(Dues::class, 'dues_id');
    }

    public function StaffRole (){
        return $this->belongsTo(StaffRole::class, 'staff_role_id');
    }

    public function TimeTable (){
        return $this->hasMany(timetable::class);
    }

    public function ExamTable (){
        return $this->hasMany(ExamTable::class);
    }
    public function Subject (){
        return $this->hasMany(Subject::class);
    }





}

