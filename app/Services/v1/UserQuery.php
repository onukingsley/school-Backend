<?php


namespace App\Services\v1;


class UserQuery extends ApiFilter
{

    protected $safeParms = [
      'name' => ['eq','like'],
      'regNo' => ['eq'],
      'userType' => ['eq'],
      'email'=> ['eq']
    ];
}
