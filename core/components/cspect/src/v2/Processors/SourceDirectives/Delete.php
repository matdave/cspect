<?php

namespace CSPect\v2\Processors\SourceDirectives;

use modObjectRemoveProcessor;

class Delete extends modObjectRemoveProcessor
{
    public $classKey = 'CSPSourceDirective';
    public $languageTopics = ['cspect:default'];
    public $objectType = 'cspect.source.directive';
}