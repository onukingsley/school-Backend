<?php
namespace App\Services\v1;
use Illuminate\Http\Request;

class ResultQuery extends ApiFilter {

    protected $safeParms = [
        'subject_id' => ['eq'],
        'student_id' => ['eq'],
        'class_type_id' => ['eq'],
        'term_id' => ['eq'],
        'academic_session_id' => ['eq'],
        'level' => ['eq'],
        'grade_id' => ['eq'],
        'test1' => ['eq','lt','gt'],
        'assignment1' => ['eq','lt','gt'],
        'assignment2' => ['eq','lt','gt'],
        'total' => ['eq','lt','gt'],
        'test2' => ['eq','lt','gt'],
        'exam' => ['eq','lt','gt'],
    ];



}
