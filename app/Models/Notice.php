<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    /** @use HasFactory<\Database\Factories\NoticeFactory> */
    use HasFactory;

    protected $fillable= ['title','message','target_audience'];

    public function casts() :  array
    {
        return [
            'target_audience' => 'array'
        ];
    }



}
