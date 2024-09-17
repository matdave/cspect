<?php

namespace CSPect\v2\Processors\Sources;

class GetList extends \modObjectGetListProcessor
{
    use \CSPect\v2\Traits\Processors\GetList;

    public $classKey = 'CSPSource';
    public string $alias = 'CSPSource';
    public $languageTopics = ['cspect'];
    public $defaultSortField = 'rank';
}