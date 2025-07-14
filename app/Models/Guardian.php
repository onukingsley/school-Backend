<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    /** @use HasFactory<\Database\Factories\GuardianFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'occupation', 'alt_phone_no', 'office_address'];


 public function User(){
     return $this->belongsTo(User::class);
 }

    public function Student(){
        return $this->hasMany(Student::class);
    }

}
