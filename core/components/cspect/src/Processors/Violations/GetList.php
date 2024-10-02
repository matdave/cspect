<?php

namespace CSPect\Processors\Violations;

use CSPect\Model\CSPViolation;
use MatDave\MODXPackage\Traits\Processors\GetList as GetListTrait;
use MODX\Revolution\Processors\Model\GetListProcessor;

class GetList extends GetListProcessor
{
    use GetListTrait;

    public $classKey = CSPViolation::class;
    public string $alias = 'CSPViolation';
    public $languageTopics = ['cspect:default'];
    public $defaultSortField = 'created_on';
    public $defaultSortDirection = 'DESC';
}