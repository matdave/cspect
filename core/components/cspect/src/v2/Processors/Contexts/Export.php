<?php

namespace CSPect\v2\Processors\Contexts;


class Export extends \modProcessor
{
    private $sources = [];
    private string $context;
    public function process()
    {
        $this->context = $this->getProperty('context_key');
        if (empty($this->context)) {
            return $this->failure('Invalid key');
        }
        if ($this->context === 'mgr') {
            return $this->outputArray([]);
        }
        $context = $this->modx->getObject('modContext', ['key' => $this->context]);
        if (empty($context)) {
            return $this->failure('Context not found');
        }
        $csp = $this->buildCSP();
        return $this->outputArray($csp);
    }
    
    public function buildCSP(): array
    {
        $this->gatherSources();

        return $this->getHeaders();
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

    protected function getHeaders(): array
    {
        $header = '';
        $this->modx->switchContext($this->context);

        $this->addDirectives($header);

        if ($header !== '') {
            $this->getReportUri($header);
            $reportingEndpoints = $this->modx->getOption('cspect.reporting_endpoints', null, '');
            if (!empty($reportingEndpoints)) {
                $reportingEndpoints = $this->parseValues($reportingEndpoints);
            }
            $this->modx->switchContext('mgr');
            return ['exportData' => $header, 'endpoints' => $reportingEndpoints];
        }
        $this->modx->switchContext('mgr');
        return ['exportData' => '', 'endpoints' => ''];
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

    protected function strContainsAny(string $haystack, array $needles): bool
    {
        foreach ($needles as $needle) {
            if (str_contains($haystack, $needle)) {
                return true;
            }
        }
        return false;
    }

    private function getReportUri(&$header): void
    {
        $reportUri = $this->modx->getOption('cspect.report_uri', null, '');
        if (!empty($reportUri)) {
            $header .= 'report-uri ' . $this->parseValues($reportUri) . '; ';
        }

        $reportTo = $this->modx->getOption('cspect.report_to', null, '');
        if (!empty($reportTo)) {
            $header .= 'report-to ' . $this->parseValues($reportTo) . '; ';
        }
    }

    private function parseValues(string $value): string
    {
        // find all {{placeholders}}
        preg_match_all('/{{(.*?)}}/', $value, $matches);
        foreach ($matches[1] as $match) {
            $value = str_replace('{{' . $match . '}}', $this->modx->getOption($match, null, ''), $value);
        }
        // find all [[++placeholders]]
        preg_match_all('/\[\[\+\+(.*?)]]/', $value, $matches);
        foreach ($matches[1] as $match) {
            $value = str_replace('[[++' . $match . ']]', $this->modx->getOption($match, null, ''), $value);
        }
        return $value;
    }
}