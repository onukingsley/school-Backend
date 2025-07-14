<?php
namespace App\Services\v1;
use Illuminate\Http\Request;

class SalaryPaymentQuery extends ApiFilter {

    protected $safeParms = [
        'staff_id' => ['eq'],
        'dues_id' => ['eq'],
        'transaction_type' => ['eq'],
        'amount' => ['eq'],
        'name' => ['eq'],
        'transaction_id' => ['eq'],
    ];

}
