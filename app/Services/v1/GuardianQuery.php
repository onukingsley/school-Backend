<?php
namespace App\Services\v1;
use Illuminate\Http\Request;

class GuardianQuery extends ApiFilter {

    protected $safeParms = [
        'user_id' => ['eq'],
        'office_address' => ['eq','like'],
        'occupation' => ['eq','like'],
        'alt_phone_no' => ['eq'],
    ];

}
