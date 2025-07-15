<?php
namespace App\Services\v1;
use Illuminate\Http\Request;

class AssignmentQuery extends ApiFilter {

    protected $safeParms = [
      'subject_id' => ['eq'],
      'class_type_id' => ['eq'],
      'due_date' => ['eq'],
      'term_id' => ['eq'],
      'academic_session_id' => ['eq'],
      'assignment_status' => ['eq'],
    ];

}
