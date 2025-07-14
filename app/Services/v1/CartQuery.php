<?php
namespace App\Services\v1;
use Illuminate\Http\Request;

class CartQuery extends ApiFilter
{
    protected $safeParms = [
        'store_id' => ['eq'],
        'product_id' => ['eq'],
        'user_id' => ['eq'],
        'productTitle' => ['eq', 'like'],
        'email' => ['eq'],
        'price' => ['eq', 'gt', 'lt'],

    ];

}

