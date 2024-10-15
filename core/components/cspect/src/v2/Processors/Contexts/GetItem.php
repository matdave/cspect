<?php

namespace CSPect\v2\Processors\Contexts;


class GetItem extends \modProcessor
{
    public function process()
    {
        $key = $this->getProperty('context_key');
        if (empty($key)) {
            return $this->failure('Invalid key');
        }
        if ($key === 'mgr') {
            return $this->outputArray([]);
        }
        $context = $this->modx->getObject('modContext', ['key' => $key]);
        if (empty($context)) {
            return $this->failure('Context not found');
        }
        $c = $this->modx->newQuery('modContextSetting');
        $c->where([
            'context_key' => $context->get('key'),
        ]);
        $c->where([
            'key:IN' => ['cspect.report_only', 'cspect.report_uri', 'cspect.report_to', 'cspect.reporting_endpoints'],
        ]);
        $settings = $this->modx->getIterator('modContextSetting', $c);
        $settingsFormat = [];
        foreach ($settings as $setting) {
            $settingsFormat[$setting->get('key')] = $setting->get('value');
        }
        return $this->outputArray($settingsFormat);
    }
}