<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    /** @use HasFactory<\Database\Factories\SubjectFactory> */
    use HasFactory;

    protected $fillable =['staff_id','description','scheme_of_work','title','class_list'];

   /* public function casts(): array
    {
        return [
          'class_list'=> 'array'
        ];
    }*/

    protected $casts = [
        'class_list' => 'array',
    ];

    public function Staff(){
        return $this->belongsTo(Staff::class);
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
    public function Exam(){
        return $this->hasMany(ExamTable::class);
    }

    public function Scheme(){
        return $this->hasMany(SchemeModel::class);
    }






}
