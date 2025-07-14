<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use League\Uri\Idna\Result;

class GradeScale extends Model
{
    /** @use HasFactory<\Database\Factories\GradeScaleFactory> */
    use HasFactory;

    protected $fillable = ['grade', 'min_score','max_score','remark'];

    public function Result(){
        return $this->hasMany(Result::class);
    }

}
