<?php
namespace App\Services\v1;
use Illuminate\Http\Request;

class NoticeQuery extends ApiFilter {

    protected $safeParms = [
        'title' => ['eq','like'],
        'message' => ['eq','like'],
        'target_audience' => ['eq','like'],
    ];

}
