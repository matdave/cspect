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
        $exclude = $this->modx->getIterator(CSPSourceContext::class, [
            'source' => $source,
        ]);
        $excludeIds = [];
        foreach ($exclude as $item) {
            $excludeIds[] = $item->get('context_key');
        }
        $c = $this->modx->newQuery(modContext::class);
        if (!empty($excludeIds)) {
            $c->where([
                'modContext.key:NOT IN' => $excludeIds,
            ]);
        }
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