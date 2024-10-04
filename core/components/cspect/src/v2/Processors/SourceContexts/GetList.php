<?php

namespace CSPect\v2\Processors\SourceContexts;

use CSPect\v2\Traits\Processors\GetList as GetListTrait;
use modObjectGetListProcessor;

class GetList extends modObjectGetListProcessor
{
    use GetListTrait;

    public $classKey = 'CSPSourceContext';
    public string $alias = 'CSPSourceContext';
    public $defaultSortField = 'source_rank';
    public array $dynamicFilter = ['context_key' => 'context_key', 'source' => 'source'];
    public $leftJoin = ['CSPSource' => 'Source', 'modContext' => 'Context'];

}