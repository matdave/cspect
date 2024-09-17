<?php

namespace CSPect\Processors\Directives;

use CSPect\Model\CSPDirective;
use MatDave\MODXPackage\Traits\Processors\GetList as GetListTrait;
use MODX\Revolution\Processors\Model\GetListProcessor;

class GetList extends GetListProcessor
{
    use GetListTrait;

    public $classKey = CSPDirective::class;
    public string $alias = 'CSPDirective';
    public $languageTopics = ['cspect'];
    public $defaultSortField = 'rank';

}