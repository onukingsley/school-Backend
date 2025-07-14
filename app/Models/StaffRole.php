<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffRole extends Model
{
    /** @use HasFactory<\Database\Factories\StaffRoleFactory> */
    use HasFactory;

    protected $fillable = ['role','description'];

    public function Staff(){
        return $this->hasMany(Staff::class);
    }

}
