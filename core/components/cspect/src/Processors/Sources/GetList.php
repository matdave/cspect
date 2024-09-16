<?php

namespace CSPect\Processors\Sources;

use CSPect\Model\CSPSource;
use MatDave\MODXPackage\Traits\Processors\GetList as GetListTrait;
use MODX\Revolution\Processors\Model\GetListProcessor;

class GetList extends GetListProcessor
{
    use GetListTrait;

    public $classKey = CSPSource::class;
    public $languageTopics = ['cspect'];

}