<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dues extends Model
{
    /** @use HasFactory<\Database\Factories\DuesFactory> */
    use HasFactory;

    protected $fillable  = ['title', 'amount'];

    public function SchoolFees (){
        return $this->hasMany(SchoolFees::class);
    }

    public function SalaryPayment (){
        return $this->hasMany(SalaryPayment::class);
    }

    public function ResultCheck (){
        return $this->hasMany(ResultsCheck::class);
    }

}
