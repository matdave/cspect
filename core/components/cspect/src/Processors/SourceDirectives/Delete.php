<?php

namespace CSPect\Processors\SourceDirectives;

use CSPect\Model\CSPSourceDirective;
use MODX\Revolution\Processors\Model\RemoveProcessor;

class Delete extends RemoveProcessor
{
    public $classKey = CSPSourceDirective::class;
    public $languageTopics = ['cspect:default'];
    public $objectType = 'cspect.source.directive';
}