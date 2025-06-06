<?php

namespace CSPect\Events;

use CSPect\Model\CSPDirective;
use CSPect\Model\CSPSource;
use CSPect\Model\CSPSourceContext;
use CSPect\Model\CSPSourceDirective;
use MatDave\MODXPackage\Elements\Event\Event;

class OnWebPagePrerender extends Event
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
        $c = $this->modx->newQuery(CSPSource::class);
        $c->leftJoin(CSPSourceContext::class, 'Contexts', 'CSPSource.id = Contexts.source');
        $c->where([
            'Contexts.context_key' => $this->context,
        ]);
        $c->sortby('CSPSource.rank', 'ASC');
        $c->select($this->modx->getSelectColumns(CSPSource::class, 'CSPSource'));
        $collection = $this->modx->getIterator(CSPSource::class, $c);
        foreach($collection as $source)
        {
            $this->sources[] = $source->toArray();
        }
        $this->modx->cacheManager->set('cspect-sources-'.$this->context, $this->sources);
    }

    protected function addHeaders(): void
    {
        $header = 'Content-Security-Policy: ';
        if ($this->modx->getOption('cspect.report_only', null, false)) {
            $header = 'Content-Security-Policy-Report-Only: ';
        }

        $this->addDirectives($header);

        if ($header !== 'Content-Security-Policy: ') {
            $this->getReportUri($header);
            header($header);
        }
    }

    protected function addDirectives(&$header): void
    {
        $cache = $this->modx->cacheManager->get('cspect-directives');
        if ($cache) {
            foreach ($cache as $directive) {
                $this->addDirective($header, $directive);
            }
        } else {
            $c = $this->modx->newQuery(CSPDirective::class);
            $c->sortby('rank', 'ASC');
            $directives = $this->modx->getIterator(CSPDirective::class, $c);
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
            $check = $this->modx->getObject(CSPSourceDirective::class, [
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

        $reportingEndpoints = $this->modx->getOption('cspect.reporting_endpoints', null, '');
        if (!empty($reportingEndpoints)) {
            header('Reporting-Endpoints: ' . $this->parseValues($reportingEndpoints));
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