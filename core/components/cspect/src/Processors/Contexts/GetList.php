<?php

namespace CSPect\Processors\Contexts;

use MatDave\MODXPackage\Traits\Processors\GetList as GetListTrait;
use MODX\Revolution\modContext;
use MODX\Revolution\Processors\Model\GetListProcessor;

class GetList extends GetListProcessor
{
    use GetListTrait;

    public $classKey = modContext::class;
    public string $alias = 'modContext';
    public $languageTopics = ['cspect:default'];
    public $defaultSortField = 'rank';
    public $defaultSortDirection = 'ASC';
    public $dynamicFilter = ['ignore_key' => 'key:!='];
}