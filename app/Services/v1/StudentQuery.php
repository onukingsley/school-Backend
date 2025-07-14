<?php
namespace App\Services\v1;
use Illuminate\Http\Request;

class StudentQuery extends ApiFilter {

    protected $safeParms = [
        'user_id' => ['eq'],
        'guardian_id' => ['eq'],
        'class_type_id' => ['eq'],
        'role' => ['eq'],
        'academic_session_id' => ['eq'],
        'academic_average' => ['eq','lt','gt'],
    ];

}
