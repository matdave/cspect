<?php

namespace CSPect\v2\Processors\Directives;

class GetList extends \modObjectGetListProcessor
{
    use \CSPect\v2\Traits\Processors\GetList;

    public $classKey = 'CSPDirective';
    public string $alias = 'CSPDirective';
    public $languageTopics = ['cspect:default'];
    public $defaultSortField = 'rank';
    public $defaultSortDirection = 'ASC';
    public $countColumn = [
        'class' => 'CSPSourceDirective',
        'alias' => 'Sources',
        'column' => '`Sources`.`directive`',
        'group' => '`CSPDirective`.`id`',
    ];
}