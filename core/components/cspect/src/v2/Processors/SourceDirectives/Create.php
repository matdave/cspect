<?php

namespace CSPect\v2\Processors\SourceDirectives;

use modObjectCreateProcessor;

class Create extends modObjectCreateProcessor
{
    public $classKey = 'CSPSourceDirective';
    public $languageTopics = ['cspect:default'];
    public $objectType = 'cspect.source.directive';
}