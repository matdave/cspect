<?php

namespace CSPect\v2\Processors\Sources;

use CSPect\Traits\Processors\Rank;
use modObjectRemoveProcessor;

class Delete extends modObjectRemoveProcessor
{
    use Rank;

    public $classKey = 'CSPSource';
    public $languageTopics = ['cspect:default'];
    public $objectType = 'cspect.source';
}