<?php
namespace App\Services\v1;
use Illuminate\Http\Request;

class GradeScaleQuery extends ApiFilter {

    protected $safeParms = [
        'grade' => ['eq'],

    ];

}
