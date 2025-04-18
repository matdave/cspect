<?php

namespace CSPect\Processors\Contexts;


use CSPect\Model\CSPDirective;
use CSPect\Model\CSPSource;
use CSPect\Model\CSPSourceContext;
use CSPect\Model\CSPSourceDirective;
use MODX\Revolution\modContext;
use MODX\Revolution\Processors\Processor;

class Import extends Processor
{
    private string $context;

    private $availableDirectives = [
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

    private $directiveIndex = 0;

    private $sourceIndex = 0;
    public function process()
    {
        $this->context = $this->getProperty('context_key', '');
        if (empty($this->context)) {
            return $this->failure('Invalid key');
        }
        if ($this->context === 'mgr') {
            return $this->outputArray([]);
        }
        $context = $this->modx->getObject(modContext::class, ['key' => $this->context]);
        if (empty($context)) {
            return $this->failure('Context not found');
        }
        $csp = $this->getProperty('csp');
        if (empty($csp)) {
            return $this->failure('CSP can\'t be empty');
        }
        return $this->processCSP(trim($csp));
    }

    private function processCSP(string $csp)
    {
        $entries = explode(";", $csp);
        if (empty($entries)) {
            return $this->failure('Unable to process entries');
        }
        $this->cleanContext();
        $results = [];
        foreach ($entries as $entry) {
            $results[] = $this->processEntry(trim($entry));
        }
        $this->cleanOrphans();
        return $this->success('', $results);
    }

    private function cleanContext(): void
    {
        $this->modx->removeCollection(CSPSourceContext::class, ['context_key' => $this->context]);
    }

    private function cleanOrphans(): void
    {
        $c = $this->modx->newQuery(CSPSource::class);
        $c->leftJoin(CSPSourceContext::class, 'Contexts');
        $c->where(['Contexts.context_key:IS' => null]);
        $orphans = $this->modx->getCollection(CSPSource::class, $c);
        foreach ($orphans as $o) {
            $o->remove();
        }

        $c = $this->modx->newQuery(CSPDirective::class);
        $c->leftJoin(CSPSourceDirective::class, 'Sources');
        $c->where(['Sources.id:IS' => null]);
        $orphans = $this->modx->getCollection(CSPDirective::class, $c);
        foreach ($orphans as $o) {
            $o->remove();
        }
    }

    private function processEntry(string $entry): string
    {
        $values = explode(" ", $entry);
        if (count($values) < 2) {
            return 'Missing Records on entry: ' . $entry;
        }
        $directive = $values[0];
        $sources = array_diff(
            $values,
            [$values[0]]
        );

        if (in_array($directive, $this->availableDirectives))
        {
            return $this->handleDirective($directive, $sources);
        }

        return 'Invalid entry: ' . $directive;
    }

    private function handleDirective(string $directive, array $sources): string
    {
        if (empty($sources)) {
            return 'No sources for directive: ' . $directive;
        }
        $directive = trim($directive);
        $cspDirective = $this->modx->getObject(CSPDirective::class, ['name' => $directive]);
        if (empty($cspDirective)) {
            $cspDirective = $this->modx->newObject(CSPDirective::class);
            $cspDirective->set('name', $directive);
        }
        $cspDirective->set('rank', $this->directiveIndex++);
        $cspDirective->save();
        $entries = [];

        foreach ($sources as $source) {
            $entries[] = $this->handleDirectiveSource($cspDirective, $source);
        }

        return 'Updated directive ' . $directive . ' with sources: ' . implode(', ', $entries);
    }

    private function handleDirectiveSource(CSPDirective $directive, string $source): string
    {
        $source = trim($source);
        $source = trim($source, "'");
        $cspSource = $this->modx->getObject(CSPSource::class, ['name' => $source]);
        if (empty($cspSource))
        {
            $cspSource = $this->modx->newObject(CSPSource::class);
            $cspSource->set('name', $source);
            $cspSource->save();
        }
        $cspSource->set('rank', $this->sourceIndex++);
        $cspSource->save();

        $sourceDirective = $this->modx->getObject(CSPSourceDirective::class,
            ['directive' => $directive->id, 'source' => $cspSource->id]
        );
        if (empty($sourceDirective)) {
            $sourceDirective = $this->modx->newObject(CSPSourceDirective::class);
            $sourceDirective->set('source', $cspSource->id);
            $sourceDirective->set('directive', $directive->id);
            $sourceDirective->save();
        }

        $sourceContext = $this->modx->getObject(CSPSourceContext::class,
            ['context_key' => $this->context, 'source' => $cspSource->id]
        );
        if (empty($sourceContext)) {
            $sourceContext = $this->modx->newObject(CSPSourceContext::class);
            $sourceContext->set('context_key', $this->context);
            $sourceContext->set('source', $cspSource->id);
            $sourceContext->save();
        }

        if ($cspSource->save())
        {
            return $cspSource->name;
        }
        return 'error-' . $source;
    }
}
