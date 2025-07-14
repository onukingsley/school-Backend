<?php
namespace App\Services\v1;
use Illuminate\Http\Request;

class PaymentQuery extends ApiFilter {

    protected $safeParms = [
        'transaction_type' => ['eq'],
        'amount' => ['eq','gt','lt'],
        'description' => ['eq','like'],
        'transaction_id' => ['eq'],
        'transaction_name' => ['eq'],
        'balance' => ['eq'],
    ];

}
