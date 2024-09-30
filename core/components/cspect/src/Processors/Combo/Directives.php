<?php

namespace CSPect\Processors\Combo;

use CSPect\Model\CSPDirective;
use CSPect\Model\CSPSourceDirective;
use MODX\Revolution\Processors\Processor;

class Directives extends Processor
{
    public function getLanguageTopics()
    {
        return ['cspect:default'];
    }

    public function process()
    {
        $source = $this->getProperty('source');
        if (empty($source)) {
            return $this->staticDirectives();
        }
        return $this->dynamicDirectives($source);
    }

    public function staticDirectives()
    {
        $availableDirectives = [
            "base-uri",
            "child-src",
            "connect-src",
            "default-src",
            "font-src",
            "form-action",
            "frame-ancestors",
            "frame-src",
            "img-src",
            "manifest-src",
            "media-src",
            "object-src",
            //"report-uri",
            "script-src",
            "script-src-attr",
            "script-src-elem",
            "style-src",
            "style-src-attr",
            "style-src-elem",
            "worker-src",
        ];

        $usedDirectives = [];
        $c = $this->modx->newQuery(CSPDirective::class);
        $directives = $this->modx->getIterator(CSPDirective::class, $c);
        foreach ($directives as $directive) {
            $usedDirectives[] = $directive->get('name');
        }

        $unusedDirectives = array_diff($availableDirectives, $usedDirectives);

        $query = $this->getProperty('query');
        if (!empty($query)) {
            $unusedDirectives = array_filter($unusedDirectives, function ($directive) use ($query) {
                return stripos($directive, $query) !== false;
            });
        }
        $start = $this->getProperty('start', 0);
        $limit = $this->getProperty('limit', 0);
        $total = count($unusedDirectives);
        if ($limit > 0) {
            $unusedDirectives = array_slice($unusedDirectives, $start, $limit);
        }
        $directivesFormat = [];

        foreach ($unusedDirectives as $directive) {
            $directivesFormat[] = [
                'value' => $directive,
            ];
        }

        return $this->outputArray(array_values($directivesFormat), $total);
    }

    public function dynamicDirectives($source)
    {
        $exclude = $this->modx->getIterator(CSPSourceDirective::class, [
            'source' => $source,
        ]);
        $excludeIds = [];
        foreach ($exclude as $item) {
            $excludeIds[] = $item->get('directive');
        }
        $c = $this->modx->newQuery(CSPDirective::class);
        $query = $this->getProperty('query');
        if (!empty($excludeIds)) {
            $c->where([
                'id:NOT IN' => $excludeIds,
            ]);
        }
        if (!empty($query)) {
            $c->where([
                'CSPDirective.name:LIKE' => "%$query%",
            ]);
        }
        $start = $this->getProperty('start', 0);
        $limit = $this->getProperty('limit', 0);
        $c->select($this->modx->getSelectColumns(CSPDirective::class, 'CSPDirective'));
        $total = $this->modx->getCount(CSPDirective::class, $c);
        $c->limit($limit, $start);
        $directives = $this->modx->getIterator(CSPDirective::class, $c);
        $directivesFormat = [];
        foreach ($directives as $directive) {
            $lexicon = $this->modx->lexicon('cspect.directive.' . $directive->get('name'));
            $directivesFormat[] = [
                'value' => $directive->get('id'),
                'text' => $lexicon ?: $directive->get('name'),
            ];
        }
        return $this->outputArray(array_values($directivesFormat), $total);
    }
}