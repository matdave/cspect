<?php

namespace CSPect\v2\Processors\Combo;

class Directives extends \modProcessor
{
    public function process()
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
            "report-uri",
            "script-src",
            "script-src-attr",
            "script-src-elem",
            "style-src",
            "style-src-attr",
            "style-src-elem",
            "worker-src",
        ];

        $usedDirectives = [];
        $c = $this->modx->newQuery('CSPDirective');
        $directives = $this->modx->getIterator('CSPDirective', $c);
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
}