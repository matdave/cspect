<?php

namespace CSPect\Processors\Sources;

use CSPect\Model\CSPSource;
use CSPect\Model\CSPSourceDirective;
use MatDave\MODXPackage\Traits\Processors\GetList as GetListTrait;
use MODX\Revolution\Processors\Model\GetListProcessor;

class GetList extends GetListProcessor
{
    use GetListTrait;

    public $classKey = CSPSource::class;
    public string $alias = 'CSPSource';
    public $languageTopics = ['cspect:default'];
    public $defaultSortField = 'rank';
    public $defaultSortDirection = 'ASC';
    public $countColumn = [
        'class' => CSPSourceDirective::class,
        'alias' => 'Directives',
        'column' => '`Directives`.`source`',
        'group' => '`CSPSource`.`id`',
    ];

}