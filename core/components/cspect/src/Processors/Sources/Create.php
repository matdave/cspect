<?php

namespace CSPect\Processors\Sources;

use CSPect\Model\CSPSource;
use CSPect\Model\CSPSourceContext;
use CSPect\Traits\Processors\Rank;
use MODX\Revolution\Processors\Model\CreateProcessor;

class Create extends CreateProcessor
{
    use Rank;

    public $classKey = CSPSource::class;
    public $objectType = 'cspect.source';

    public function afterSave()
    {
        $defaultContexts = $this->modx->getOption('cspect.default_contexts', [], '');
        if (!empty($defaultContexts)) {
            $defaultContexts = explode(',', $defaultContexts);
            $contexts = [];
            foreach ($defaultContexts as $context) {
                $obj = $this->modx->newObject(CSPSourceContext::class);
                $obj->set('context_key', $context);
                $contexts[] = $obj;
            }
            $this->object->addMany($contexts, 'Contexts');
            $this->object->save();
        }
        return parent::afterSave();
    }
}