<?php


namespace App\Services\v1;


class StaffRole extends ApiFilter
{
    protected $safeParms = [
        'role' => ['eq'],
        'description' => ['eq','like'],

    ];
}
