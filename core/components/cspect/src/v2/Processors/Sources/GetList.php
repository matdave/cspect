<?php

namespace CSPect\v2\Processors\Sources;

use modObjectGetListProcessor;

class GetList extends modObjectGetListProcessor
{
    use \CSPect\v2\Traits\Processors\GetList;

    public $classKey = 'CSPSource';
    public string $alias = 'CSPSource';
    public $languageTopics = ['cspect:default'];
    public $defaultSortField = 'rank';
    public $defaultSortDirection = 'ASC';
    public $countColumn = [
        'class' => 'CSPSourceDirective',
        'alias' => 'Directives',
        'column' => '`Directives`.`source`',
        'group' => '`CSPSource`.`id`',
    ];

    public $dynamicFilter = [
        'query' => 'name:LIKE',
    ];
}