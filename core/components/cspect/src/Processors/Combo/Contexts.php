<?php

namespace CSPect\Processors\Combo;

use CSPect\Model\CSPSourceContext;
use MODX\Revolution\modContext;
use MODX\Revolution\Processors\Processor;

class Contexts extends Processor
{
    public function process()
    {
        $source = $this->getProperty('source');
        if (empty($source)) {
            return $this->failure('Invalid source');
        }
        $c = $this->modx->newQuery(modContext::class);
        $c->leftJoin(CSPSourceContext::class, 'CSPSourceContext', 'CSPSourceContext.context_key = modContext.key');
        $c->where([
            'CSPSourceContext.source:!=' => $source,
            'OR:CSPSourceContext.source:IS' => null,
        ]);
        $query = $this->getProperty('query');
        if (!empty($query)) {
            $c->where([
                'modContext.key:LIKE' => '%' . $query . '%',
                'OR:modContext.name:LIKE' => '%' . $query . '%',
            ]);
        }
        $c->where([
            'modContext.key:!=' => 'mgr',
        ]);
        $c->select($this->modx->getSelectColumns(modContext::class, 'modContext'));
        $total = $this->modx->getCount(modContext::class, $c);
        $c->sortby('modContext.rank');
        $limit = $this->getProperty('limit', 0);
        $start = $this->getProperty('start', 0);
        $c->limit($limit, $start);
        $contexts = $this->modx->getIterator(modContext::class, $c);
        $contextsFormat = [];
        foreach ($contexts as $context) {
            $contextsFormat[] = [
                'value' => $context->get('key'),
                'text' => $context->get('name') ?: $context->get('key'),
            ];
        }
        return $this->outputArray(array_values($contextsFormat), $total);
    }
}