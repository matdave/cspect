<?php

namespace CSPect\v2\Processors\Contexts;

use CSPect\v2\Traits\Processors\GetList as GetListTrait;

class GetList extends \modObjectGetListProcessor
{
    use GetListTrait;

    public $classKey = 'modContext';
    public string $alias = 'modContext';
    public $languageTopics = ['cspect:default'];
    public $defaultSortField = 'rank';
    public $defaultSortDirection = 'ASC';

    public $dynamicFilter = ['ignore_key' => 'key:!='];
}