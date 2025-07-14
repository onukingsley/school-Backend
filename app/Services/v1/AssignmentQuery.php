<?php
namespace App\Services\v1;
use Illuminate\Http\Request;

class AssignmentQuery extends ApiFilter {

    protected $safeParms = [
      'subject_id' => ['eq'],
      'class_type_id' => ['eq'],
      'due_date' => ['eq'],
    ];

}
