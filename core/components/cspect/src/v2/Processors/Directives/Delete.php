<?php

namespace CSPect\v2\Processors\Directives;

use CSPect\Traits\Processors\Rank;
use modObjectRemoveProcessor;

class Delete extends modObjectRemoveProcessor
{
    use Rank;

    public $classKey = 'CSPDirective';
    public $languageTopics = ['cspect:default'];
    public $objectType = 'cspect.directive';
}