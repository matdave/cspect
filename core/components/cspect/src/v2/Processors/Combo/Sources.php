<?php

namespace CSPect\v2\Processors\Combo;

use modProcessor;

class Sources extends modProcessor
{
    public function process()
    {
        $directive = $this->getProperty('directive');
        $query = $this->getProperty('query');
        if (empty($directive)) {
            return $this->failure('Directive is required');
        }
        $exclude = $this->modx->getIterator('CSPSourceDirective', [
            'directive' => $directive,
        ]);
        $excludeIds = [];
        foreach ($exclude as $item) {
            $excludeIds[] = $item->get('source');
        }
        $c = $this->modx->newQuery('CSPSource');
        $c->where([
            'id:NOT IN' => $excludeIds,
        ]);
        if (!empty($query)) {
            $c->where([
                'name:LIKE' => '%' . $query . '%',
            ]);
        }
        $c->select($this->modx->getSelectColumns('CSPSource', 'CSPSource'));
        $c->sortby('CSPSource.rank', 'ASC');
        $start = $this->getProperty('start', 0);
        $limit = $this->getProperty('limit', 10);
        $c->limit($limit, $start);
        $total = $this->modx->getCount('CSPSource', $c);
        $sources = $this->modx->getIterator('CSPSource', $c);
        $sourcesFormat = [];
        foreach ($sources as $source) {
            $sourcesFormat[] = [
                'value' => $source->get('id'),
                'text' => $source->get('name'),
            ];
        }
        return $this->outputArray(array_values($sourcesFormat), $total);
    }
}
