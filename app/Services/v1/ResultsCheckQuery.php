<?php
namespace App\Services\v1;
use Illuminate\Http\Request;

class ResultsCheckQuery extends ApiFilter {

    protected $safeParms = [
        'student_id' => ['eq'],
        'dues_id' => ['eq'],
        'token' => ['eq'],
        'status' => ['eq'],
        'number_of_attempt' => ['eq','lt','gt'],
    ];

}
