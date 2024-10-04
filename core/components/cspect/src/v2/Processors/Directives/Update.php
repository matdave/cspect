<?php

namespace CSPect\v2\Processors\Directives;

use CSPect\Traits\Processors\Rank;
use modObjectUpdateProcessor;

class Update extends modObjectUpdateProcessor
{
    use Rank;

    public $classKey = 'CSPDirective';
    public $objectType = 'cspect.directive';
}