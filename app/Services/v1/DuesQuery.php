<?php
namespace App\Services\v1;
use Illuminate\Http\Request;

class DuesQuery extends ApiFilter {

    protected $safeParms = [
        'title' => ['eq','like'],
        'amount' => ['eq','gt','lt'],

    ];

}
