<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryPayment extends Model
{
    /** @use HasFactory<\Database\Factories\SalaryPaymentFactory> */
    use HasFactory;

    protected $fillable = ['staff_id','dues_id','transaction_type','amount','name','transaction_id'];

    public function Staff(){
        return $this->belongsTo(Staff::class);
    }

    public function Dues(){
        return $this->belongsTo(Dues::class);
    }


}
