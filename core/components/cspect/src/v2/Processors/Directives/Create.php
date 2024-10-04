<?php

namespace CSPect\v2\Processors\Directives;

use CSPect\Traits\Processors\Rank;
use modObjectCreateProcessor;

class Create extends modObjectCreateProcessor
{
    use Rank;

    public $classKey = 'CSPDirective';
    public $objectType = 'cspect.directive';
}