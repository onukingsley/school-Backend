<?php


namespace App\Services\v1;


use Illuminate\Http\Request;

class ApiFilter {
    protected $safeParms = [];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        'like' => 'like',
    ];

    protected  $columnMap = [];

    public function transform(Request $request){
        $eloquery = [];

        foreach ($this->safeParms as $parm=>$operators){
            $query = $request->query($parm);
            if (!isset($query)){
                continue;
            }
            //$column =  $parm;
           // $column = $this->columnMap[$parm] ?? $parm;
            $column = isset($this->columnMap[$parm]) ? $this->columnMap[$parm] : $parm;

            foreach ($operators as $operator){
                if (isset($query[$operator])){
                    $eloquery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }
        return $eloquery;
    }
}
