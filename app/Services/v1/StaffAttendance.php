<?php

namespace App\Services\v1;

class StaffAttendance extends ApiFilter
{
    protected  $safeParms = [
        'staff_id' => ['eq'],
        'academic_session_id' => ['eq'],
        'term_id' => ['eq'],
    ];
}
