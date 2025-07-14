<?php

namespace App\Services\v1;

use Illuminate\Http\Request;

class ApiFilter
{
    protected array $safeParms = [];

    protected array $operatorMap = [
        'eq'   => '=',
        'lt'   => '<',
        'lte'  => '<=',
        'gt'   => '>',
        'gte'  => '>=',
        'like' => 'like',
    ];

    protected array $columnMap = [];

    protected array $directFilters = [];   // For where()
    protected array $relationFilters = []; // For whereHas()

    public function transform(Request $request): array
    {
        $this->directFilters = [];
        $this->relationFilters = [];

        foreach ($this->safeParms as $param => $operators) {
            $queryValue = $request->query($param);

            if (!is_array($queryValue)) continue;

            $mappedColumn = $this->columnMap[$param] ?? $param;

            foreach ($operators as $operatorKey) {
                if (!isset($queryValue[$operatorKey])) continue;

                $value = $queryValue[$operatorKey];
                $sqlOperator = $this->operatorMap[$operatorKey] ?? '=';

                // Wrap value in % for like
                if ($sqlOperator === 'like' && strpos($value, '%') === false) {
                    $value = "%$value%";
                }

                // Detect related filter (e.g. staff.name)
                if (str_contains($mappedColumn, '.')) {
                    [$relation, $column] = explode('.', $mappedColumn, 2);
                    $this->relationFilters[$relation][] = [$column, $sqlOperator, $value];
                } else {
                    $this->directFilters[] = [$mappedColumn, $sqlOperator, $value];
                }
            }
        }

        return [
            'direct' => $this->directFilters,
            'relations' => $this->relationFilters,
        ];
    }
}
