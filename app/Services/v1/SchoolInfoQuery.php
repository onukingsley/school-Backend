<?php
namespace App\Services\v1;
use Illuminate\Http\Request;

class SchoolInfoQuery extends ApiFilter {

    protected $safeParms = [
        'name' => ['eq','like'],
        'phone_no' => ['eq'],
        'email_address' => ['like'],
    ];

}
