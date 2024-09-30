<?php

namespace CSPect\Processors\SourceContexts;

use CSPect\Model\CSPSourceContext;
use MODX\Revolution\Processors\Model\RemoveProcessor;

class Delete extends RemoveProcessor
{
    public $classKey = CSPSourceContext::class;
    public $languageTopics = ['cspect:default'];
    public $objectType = 'cspect.source.context';
}