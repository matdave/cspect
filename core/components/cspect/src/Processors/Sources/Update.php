<?php

namespace CSPect\Processors\Sources;

use CSPect\Model\CSPSource;
use CSPect\Traits\Processors\Rank;
use MODX\Revolution\Processors\Model\UpdateProcessor;

class Update extends UpdateProcessor
{
    use Rank;

    public $classKey = CSPSource::class;
    public $objectType = 'cspect.source';
}