<?php

namespace CSPect\v2\Processors\Violations;

use CSPect\v2\Traits\Processors\GetList as GetListTrait;
use modObjectGetListProcessor;

class GetList extends modObjectGetListProcessor
{
    use GetListTrait;

    public $classKey = 'CSPViolation';
    public string $alias = 'CSPViolation';
    public $languageTopics = ['cspect:default'];
    public $defaultSortField = 'created_on';
    public $defaultSortDirection = 'DESC';
}