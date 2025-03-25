<?php

namespace CSPect\v2\Events;

use CSPect\Events\OnWebPagePrerender as OnWebPagePrerenderBase;

class OnWebPagePrerender extends OnWebPagePrerenderBase
{
    private $sources = [];
    private string $context;

    public function run()
    {
        $this->context = $this->modx->context->get('key');
        if (empty($this->context) || $this->context === 'mgr') {
            return;
        }

        $this->gatherSources();
        $this->addHeaders();
    }

    protected function gatherSources(): void
    {
        $cache = $this->modx->cacheManager->get('cspect-sources-'.$this->context);
        if ($cache) {
            $this->sources = $cache;
            return;
        }
        $c = $this->modx->newQuery('CSPSource');
        $c->leftJoin('CSPSourceContext', 'Contexts', 'CSPSource.id = Contexts.source');
        $c->where([
            'Contexts.context_key' => $this->context,
        ]);
        $c->sortby('CSPSource.rank', 'ASC');
        $c->select($this->modx->getSelectColumns('CSPSource', 'CSPSource'));
        $collection = $this->modx->getIterator('CSPSource', $c);
        foreach($collection as $source)
        {
            $this->sources[] = $source->toArray();
        }
        $this->modx->cacheManager->set('cspect-sources-'.$this->context, $this->sources);
    }

    protected function addDirectives(&$header): void
    {
        $cache = $this->modx->cacheManager->get('cspect-directives');
        if ($cache) {
            foreach ($cache as $directive) {
                $this->addDirective($header, $directive);
            }
        } else {
            $c = $this->modx->newQuery('CSPDirective');
            $c->sortby('rank', 'ASC');
            $directives = $this->modx->getIterator('CSPDirective', $c);
            $directivesRaw = [];
            foreach ($directives as $directive) {
                $directive = $directive->toArray();
                $directivesRaw[] = $directive;
                $this->addDirective($header, $directive);
            }
            $this->modx->cacheManager->set('cspect-directives', $directivesRaw);
        }
    }

    protected function addDirective(&$header, array $directive): void
    {
        $sources = [];
        foreach ($this->sources as $source) {
            $check = $this->modx->getObject('CSPSourceDirective', [
                'source' => $source['id'],
                'directive' => $directive['id'],
            ]);
            if (!empty($check)) {
                if ($this->strContainsAny($source['name'], ['.', ':'])) {
                    $sources[] = $source['name'];
                } else {
                    $sources[] = "'{$source['name']}'";
                }
            }
        }
        if (!empty($sources)) {
            $header .= $directive['name'] . ' ' . implode(' ', $sources) . '; ';
        }
    }
}