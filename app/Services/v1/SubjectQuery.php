<?php
namespace App\Services\v1;
use Illuminate\Http\Request;

class SubjectQuery extends ApiFilter {

    protected $safeParms = [
        'staff_id' => ['eq'],
        'title' => ['eq','like'],

    ];

}
