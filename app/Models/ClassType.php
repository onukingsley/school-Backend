<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassType extends Model
{
    /** @use HasFactory<\Database\Factories\ClassTypeFactory> */
    use HasFactory;

    protected $fillable = ['staff_id','class_name','number_of_students','class_type_name','subject'];



    protected $casts = [
        'subject' => 'array',
    ];


    public function Staff(){
        return $this->belongsTo(Staff::class);
    }

    public function Exam(){
        return $this->hasMany(ExamTable::class);
    }

    public function Assignment(){
        return $this->hasMany(Assignment::class);
    }

    public function TimeTable(){
        return $this->hasMany(timetable::class);
    }
    public function Result(){
        return $this->hasMany(Results::class);
    }

    public function Attendance(){
        return $this->hasMany(Attendance::class);
    }

    public function Student (){
        return $this->hasMany(Student::class);
    }






}
