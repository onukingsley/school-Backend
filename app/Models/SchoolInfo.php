<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolInfo extends Model
{
    /** @use HasFactory<\Database\Factories\SchoolInfoFactory> */
    use HasFactory;

    protected $fillable = ['name','site_images','school_image','principal_details','nav_bar','address','motor','po_box','long_lat','phone_no','theme_color','email_address'];

    public function casts(): array
    {
        return [
          'site_images'=>'json',
          'school_image'=>'json',
          'principal_details'=>'json',
          'nav_bar'=>'json',
          'theme_color'=>'json',
        ];
    }


}
