<?php

namespace CSPect\v2\Events;

use MatDave\MODXPackage\Elements\Event\Event;

class OnWebPagePrerender extends Event
{
    private $sources = [];

    public function run()
    {
        $context = $this->modx->context->get('key');
        if (empty($context) || $context === 'mgr') {
            return;
        }

        $this->gatherSources($context);
        $this->addHeaders();
    }

    public function gatherSources($context): void
    {
        $c = $this->modx->newQuery('CSPSource');
        $c->leftJoin('CSPSourceContext', 'Contexts', 'CSPSource.id = Contexts.source');
        $c->where([
            'Contexts.context_key' => $context,
        ]);
        $c->sortby('CSPSource.rank', 'ASC');
        $c->select($this->modx->getSelectColumns('CSPSource', 'CSPSource'));
        $this->sources = $this->modx->getIterator('CSPSource', $c);
    }

    public function addHeaders(): void
    {
        $header = 'Content-Security-Policy: ';
        if ($this->modx->getOption('cspect.report_only', null, false)) {
            $header = 'Content-Security-Policy-Report-Only: ';
        }
        $c = $this->modx->newQuery('CSPDirective');
        $c->sortby('rank', 'ASC');
        $directives = $this->modx->getIterator('CSPDirective', $c);
        foreach ($directives as $directive) {
            $this->addDirective($header, $directive);
        }
        if ($header !== 'Content-Security-Policy: ') {
            $this->getReportUri($header);
            header($header);
        }
    }

    public function addDirective(&$header, $directive): void
    {
        $sources = [];
        foreach ($this->sources as $source) {
            $check = $this->modx->getObject('CSPSourceDirective', [
                'source' => $source->get('id'),
                'directive' => $directive->get('id'),
            ]);
            if (!empty($check)) {
                if ($this->strContainsAny($source->get('name'), ['.', ':'])) {
                    $sources[] = $source->get('name');
                } else {
                    $sources[] = "'{$source->get('name')}'";
                }
            }
        }
        if (!empty($sources)) {
            $header .= $directive->get('name') . ' ' . implode(' ', $sources) . '; ';
        }
    }

    private function strContainsAny(string $haystack, array $needles): bool
    {
        foreach ($needles as $needle) {
            if (str_contains($haystack, $needle)) {
                return true;
            }
        }
        return false;
    }

    public function getReportUri(&$header): void
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

    public function parseValues(string $value): string
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