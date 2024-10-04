<?php

namespace CSPect\v2\Processors\Violations;

use modProcessor;

class AutoFix extends modProcessor
{
    public function process()
    {
        $contextKey = $this->getProperty('context_key');
        $directive_str = $this->getProperty('directive');
        $blocked = $this->getProperty('blocked');

        if (empty($contextKey) || empty($directive_str) || empty($blocked)) {
            return $this->failure('Missing required properties');
        }

        $source_str = $this->getSource($blocked, $contextKey);

        if ($source_str == 'none') {
            return $this->failure('Unable to determine source');
        }

        $source = $this->modx->getObject('CSPSource', ['name' => $source_str]);
        if (empty($source)) {
            $sourceRank = 1;
            $c = $this->modx->newQuery('CSPSource');
            $c->sortby('rank', 'DESC');
            $lastSource = $this->modx->getObject('CSPSource', $c);
            if ($lastSource) {
                $sourceRank = $lastSource->get('rank') + 1;
            }
            $source = $this->modx->newObject('CSPSource');
            $source->set('name', $source_str);
            $source->set('rank', $sourceRank);
            $source->save();
        }

        $context = $this->modx->getObject('modContext', ['key' => $contextKey]);
        if (!$context) {
            return $this->failure('Context not found');
        }

        $directive = $this->modx->getObject('CSPDirective', ['name' => $directive_str]);
        if (empty($directive)) {
            $directiveRank = 1;
            $c = $this->modx->newQuery('CSPDirective');
            $c->sortby('rank', 'DESC');
            $lastDirective = $this->modx->getObject('CSPDirective', $c);
            if ($lastDirective) {
                $directiveRank = $lastDirective->get('rank') + 1;
            }
            $directive = $this->modx->newObject('CSPDirective');
            $directive->set('name', $directive_str);
            $directive->set('rank', $directiveRank);
            $directive->save();
        }

        $sourceContext = $this->modx->getObject('CSPSourceContext',
            [
                'context_key' => $contextKey,
                'source' => $source->get('id')
            ]
        );
        if (empty($sourceContext)) {
            $sourceContext = $this->modx->newObject('CSPSourceContext');
            $sourceContext->set('source', $source->get('id'));
            $sourceContext->set('context_key', $context->get('key'));
            $sourceContext->save();
        }

        $sourceDirective = $this->modx->getObject('CSPSourceDirective',
            [
                'directive' => $directive->get('id'),
                'source' => $source->get('id')
            ]
        );
        if (empty($sourceDirective)) {
            $sourceDirective = $this->modx->newObject('CSPSourceDirective');
            $sourceDirective->set('source', $source->get('id'));
            $sourceDirective->set('directive', $directive->get('id'));
            $sourceDirective->save();
        }

        $this->modx->removeCollection('CSPViolation', [
            'directive' => $directive_str,
            'blocked:LIKE' => '%' . $blocked . '%',
            'context_key' => $contextKey
        ]);

        return $this->success('AutoFix applied');
    }

    private function getSource($blocked, $contextKey = 'web')
    {
        if (str_contains($blocked, '://')) {
            $parsedUrl = parse_url($blocked);
            // get the protocol and domain
            $url = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
            $this->modx->switchContext($contextKey, true);
            $site_url = $this->modx->getOption('site_url');
            if (str_starts_with($site_url, $url) || str_starts_with($url, $site_url)) {
                $url = 'self';
            }
            $this->modx->switchContext('mgr', true);
            return $url;
        }
        if (str_starts_with($blocked, '/')) {
            return 'self';
        }
        if (str_starts_with($blocked, 'data')) {
            return 'data:';
        }
        if (str_starts_with($blocked, 'blob')) {
            return 'blob:';
        }
        if (str_starts_with($blocked, 'filesystem')) {
            return 'filesystem:';
        }
        if (str_starts_with($blocked, 'mediastream')) {
            return 'mediastream:';
        }
        if (str_starts_with($blocked, 'ws:')) {
            return 'ws:';
        }
        if (str_starts_with($blocked, 'wss:')) {
            return 'wss:';
        }
        if ($blocked == 'inline') {
            return 'unsafe-inline';
        }
        if ($blocked == 'eval') {
            return 'unsafe-eval';
        }
        return 'none';
    }
}