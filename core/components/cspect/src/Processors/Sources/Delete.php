<?php

namespace CSPect\Processors\Sources;

use CSPect\Model\CSPSource;
use CSPect\Traits\Processors\Rank;
use MODX\Revolution\Processors\Model\RemoveProcessor;

class Delete extends RemoveProcessor
{
    use Rank;

    public $classKey = CSPSource::class;
    public $languageTopics = ['cspect:default'];
    public $objectType = 'cspect.source';
}