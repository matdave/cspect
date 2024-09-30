<?php

namespace CSPect\Processors\SourceDirectives;


use CSPect\Model\CSPDirective;
use CSPect\Model\CSPSource;
use CSPect\Model\CSPSourceDirective;
use MatDave\MODXPackage\Traits\Processors\GetList as GetListTrait;
use MODX\Revolution\Processors\Model\GetListProcessor;

class GetList extends GetListProcessor
{
    use GetListTrait;

    public $classKey = CSPSourceDirective::class;
    public string $alias = 'CSPSourceDirective';
    public $defaultSortField = 'source_rank';
    public array $dynamicFilter = ['directive' => 'directive', 'source' => 'source'];
    public $leftJoin = [CSPSource::class => 'Source', CSPDirective::class => 'Directive'];

}