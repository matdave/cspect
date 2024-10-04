<?php

namespace CSPect\v2\Processors\SourceDirectives;


use CSPect\v2\Traits\Processors\GetList as GetListTrait;
use modObjectGetListProcessor;

class GetList extends modObjectGetListProcessor
{
    use GetListTrait;

    public $classKey = 'CSPSourceDirective';
    public string $alias = 'CSPSourceDirective';
    public $defaultSortField = 'source_rank';
    public array $dynamicFilter = ['directive' => 'directive', 'source' => 'source'];
    public $leftJoin = ['CSPSource' => 'Source', 'CSPDirective' => 'Directive'];

}