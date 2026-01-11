<?php
namespace App\Services\v1;
use Illuminate\Http\Request;

class ClassTypeQuery extends ApiFilter {

    protected array $safeParms = [
        'subject' => ['eq'],
        'staff_id' => ['eq'],
        'class_type_name' => ['eq'],
        'class_name' => ['eq'],
        'number_of_students' => ['eq','gt','lt'],
        'due_date' => ['eq'],
    ];

}
