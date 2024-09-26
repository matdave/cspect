<?php

namespace CSPect\Processors\Directives;

use CSPect\Model\CSPDirective;
use CSPect\Processors\DDReorderProcessor;

class DDReorder extends DDReorderProcessor
{
    public $classKey = CSPDirective::class;
    public $objectType = 'cspect.directives';
}