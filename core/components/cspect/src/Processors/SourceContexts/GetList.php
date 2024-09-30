<?php

namespace CSPect\Processors\SourceContexts;


use CSPect\Model\CSPSource;
use CSPect\Model\CSPSourceContext;
use MatDave\MODXPackage\Traits\Processors\GetList as GetListTrait;
use MODX\Revolution\Processors\Model\GetListProcessor;
use MODX\Revolution\modContext;

class GetList extends GetListProcessor
{
    use GetListTrait;

    public $classKey = CSPSourceContext::class;
    public string $alias = 'CSPSourceContext';
    public $defaultSortField = 'source_rank';
    public array $dynamicFilter = ['context_key' => 'context_key', 'source' => 'source'];
    public $leftJoin = [CSPSource::class => 'Source', modContext::class => 'Context'];

}