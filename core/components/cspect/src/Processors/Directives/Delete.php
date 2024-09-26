<?php

namespace CSPect\Processors\Directives;

use CSPect\Model\CSPDirective;
use CSPect\Traits\Processors\Rank;
use MODX\Revolution\Processors\Model\RemoveProcessor;

class Delete extends RemoveProcessor
{
    use Rank;

    public $classKey = CSPDirective::class;
    public $languageTopics = ['cspect:default'];
    public $objectType = 'cspect.directive';
}