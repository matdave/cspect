<?php

namespace CSPect\Processors\Directives;

use CSPect\Model\CSPDirective;
use CSPect\Model\CSPSourceDirective;
use MatDave\MODXPackage\Traits\Processors\GetList as GetListTrait;
use MODX\Revolution\Processors\Model\GetListProcessor;

class GetList extends GetListProcessor
{
    use GetListTrait;

    public $classKey = CSPDirective::class;
    public string $alias = 'CSPDirective';
    public $languageTopics = ['cspect'];
    public $defaultSortField = 'rank';
    public $countColumn = [
        'class' => CSPSourceDirective::class,
        'alias' => 'Directives',
        'column' => 'source',
        'group' => 'source',
    ];

}