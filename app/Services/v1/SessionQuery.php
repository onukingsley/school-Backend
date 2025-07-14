<?php
namespace App\Services\v1;
use Illuminate\Http\Request;

class SessionQuery extends ApiFilter {

    protected $safeParms = [
        'year' => ['eq','like'],

    ];

}
