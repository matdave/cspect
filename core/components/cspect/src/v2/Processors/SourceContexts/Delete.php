<?php

namespace CSPect\v2\Processors\SourceContexts;

use modObjectRemoveProcessor;

class Delete extends modObjectRemoveProcessor
{
    public $classKey = 'CSPSourceContext';
    public $languageTopics = ['cspect:default'];
    public $objectType = 'cspect.source.context';
}