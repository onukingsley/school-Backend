<?php
namespace App\Services\v1;
use Illuminate\Http\Request;

class ExamTableQuery extends ApiFilter {

    protected $safeParms = [
        'subject_id' => ['eq'],
        'class_type_id' => ['eq'],
        'invigilator' => ['eq'],
        'academic_session_id' => ['eq'],
        'term_id' => ['eq'],
        'time_range' => ['eq'],
        'staff_id' => ['eq'],
    ];

}
