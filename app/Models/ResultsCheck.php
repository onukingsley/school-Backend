<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultsCheck extends Model
{
    /** @use HasFactory<\Database\Factories\ResultsCheckFactory> */
    use HasFactory;

    protected $fillable = ['student_id','dues_id','token','number_of_attempts','status'];

    public function Student(){
        return $this->belongsTo(Student::class);
    }

    public function Dues (){
        return $this->belongsTo(Dues::class);
    }
}
