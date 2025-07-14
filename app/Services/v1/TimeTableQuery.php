<?php
namespace App\Services\v1;
use Illuminate\Http\Request;

class TimeTableQuery extends ApiFilter {

    protected $safeParms = [
        'subject_title' => ['eq','like'],
        'class_type_id' => ['eq'],
        'subject_id' => ['eq'],
        'staff_id' => ['eq'],
        'term_id' => ['eq'],
        'time_range' => ['eq'],
        'academic_session_id' => ['eq'],
        'day_of_the_week' => ['eq'],
    ];

}
