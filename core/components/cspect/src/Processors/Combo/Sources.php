<?php

namespace CSPect\Processors\Combo;

use CSPect\Model\CSPSource;
use CSPect\Model\CSPSourceDirective;
use MODX\Revolution\Processors\Processor;

class Sources extends Processor
{
    public function process()
    {
        $directive = $this->getProperty('directive');
        $query = $this->getProperty('query');
        if (empty($directive)) {
            return $this->failure('Directive is required');
        }
        $exclude = $this->modx->getIterator(CSPSourceDirective::class, [
            'directive' => $directive,
        ]);
        $excludeIds = [];
        foreach ($exclude as $item) {
            $excludeIds[] = $item->get('source');
        }
        $c = $this->modx->newQuery(CSPSource::class);
        $c->where([
            'id:NOT IN' => $excludeIds,
        ]);
        if (!empty($query)) {
            $c->where([
                'name:LIKE' => '%' . $query . '%',
            ]);
        }
        $c->select($this->modx->getSelectColumns(CSPSource::class, 'CSPSource'));
        $c->sortby('CSPSource.rank', 'ASC');
        $start = $this->getProperty('start', 0);
        $limit = $this->getProperty('limit', 10);
        $c->limit($limit, $start);
        $total = $this->modx->getCount(CSPSource::class, $c);
        $sources = $this->modx->getIterator(CSPSource::class, $c);
        $sourcesFormat = [];
        foreach ($sources as $source) {
            $sourcesFormat[] = [
                'value' => $source->get('id'),
                'text' => $source->get('name'),
            ];
        }
        return  $this->outputArray(array_values($sourcesFormat), $total);
    }
}
