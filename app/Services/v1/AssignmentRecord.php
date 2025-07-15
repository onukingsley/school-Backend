<?php
namespace App\Services\v1;

class AssignmentRecord extends ApiFilter {

    protected $safeParms = [
      'term' => ['eq'],
      'score' => ['gt','lt','eq'],
      'student_id' => ['eq'],
      'assignment_id' => ['eq'],
      'session' => ['eq','lt','gt'],
    ];
}

