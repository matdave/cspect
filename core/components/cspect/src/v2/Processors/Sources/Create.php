<?php

namespace CSPect\v2\Processors\Sources;

use CSPect\Traits\Processors\Rank;
use modObjectCreateProcessor;

class Create extends modObjectCreateProcessor
{
    use Rank;

    public $classKey = 'CSPSource';
    public $objectType = 'cspect.source';

    public function afterSave()
    {
        $defaultContexts = $this->modx->getOption('cspect.default_contexts', [], '');
        if (!empty($defaultContexts)) {
            $defaultContexts = explode(',', $defaultContexts);
            $contexts = [];
            foreach ($defaultContexts as $context) {
                $obj = $this->modx->newObject('CSPSourceContext');
                $obj->set('context_key', $context);
                $contexts[] = $obj;
            }
            $this->object->addMany($contexts, 'Contexts');
            $this->object->save();
        }
        return parent::afterSave();
    }
}