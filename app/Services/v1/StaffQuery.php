<?php
namespace App\Services\v1;
use Illuminate\Http\Request;

class StaffQuery extends ApiFilter {

    protected $safeParms = [
        'phone_no' => ['eq'],
        'account_no' => ['eq'],
        'user_id' => ['eq'],
        'staff_role_id' => ['eq'],
        'dues_id' => ['eq'],
    ];

}
