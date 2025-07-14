<?php
namespace App\Services\v1;
use Illuminate\Http\Request;

class AttendanceQuery extends ApiFilter {

    protected $safeParms = [
        'student_id' => ['eq'],
        'class_id' => ['eq'],
        'academic_session_id' => ['eq'],
        'term_id' => ['eq'],
    ];

}
