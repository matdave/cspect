<?php

namespace CSPect\Processors\Directives;

use CSPect\Model\CSPDirective;
use CSPect\Traits\Processors\Rank;
use MODX\Revolution\Processors\Model\UpdateProcessor;

class Update extends UpdateProcessor
{
    use Rank;

    public $classKey = CSPDirective::class;
    public $objectType = 'cspect.directive';
}