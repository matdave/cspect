<?php

namespace CSPect\Processors\Sources;

use CSPect\Model\CSPSource;
use CSPect\Processors\DDReorderProcessor;

class DDReorder extends DDReorderProcessor
{
    public $classKey = CSPSource::class;
    public $objectType = 'cspect.directives';
}