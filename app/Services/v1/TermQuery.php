<?php
namespace App\Services\v1;
use Illuminate\Http\Request;

class TermQuery extends ApiFilter {

    protected $safeParms = [
        'name' => ['eq','like'],
        'academic_session_id' => ['eq'],

    ];

}
