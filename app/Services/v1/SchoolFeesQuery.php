<?php
namespace App\Services\v1;
use Illuminate\Http\Request;

class SchoolFeesQuery extends ApiFilter {

    protected $safeParms = [
        'student_id' => ['eq'],
        'dues_id' => ['eq'],
        'transaction_id' => ['eq'],
        'academic_session_id' => ['eq'],
        'term_id' => ['eq'],
        'name' => ['eq','like'],
        'amount' => ['eq','lt','gt'],
    ];

}
