<?php

namespace CSPect\v2\Processors\SourceContexts;

use modObjectCreateProcessor;

class Create extends modObjectCreateProcessor
{
    public $classKey = 'CSPSourceContext';
    public $languageTopics = ['cspect:default'];
    public $objectType = 'cspect.source.context';
}