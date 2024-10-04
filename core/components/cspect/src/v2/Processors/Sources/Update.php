<?php

namespace CSPect\v2\Processors\Sources;

use CSPect\Traits\Processors\Rank;
use modObjectUpdateProcessor;

class Update extends modObjectUpdateProcessor
{
    use Rank;

    public $classKey = 'CSPSource';
    public $objectType = 'cspect.source';
}