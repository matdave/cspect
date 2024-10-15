<?php

namespace CSPect\Processors\Contexts;

use MODX\Revolution\modContext;
use MODX\Revolution\modContextSetting;
use MODX\Revolution\Processors\Processor;

class GetItem extends Processor
{
    public function process()
    {
        $key = $this->getProperty('context_key');
        if (empty($key)) {
            return $this->failure('Invalid key');
        }
        $context = $this->modx->getObject(modContext::class, ['key' => $key]);
        if (empty($context)) {
            return $this->failure('Context not found');
        }
        $c = $this->modx->newQuery(modContextSetting::class);
        $c->where([
            'context_key' => $context->get('key'),
        ]);
        $c->where([
            'key:IN' => ['cspect.report_only', 'cspect.report_uri', 'cspect.report_to', 'cspect.reporting_endpoints'],
        ]);
        $settings = $this->modx->getIterator(modContextSetting::class, $c);
        $settingsFormat = [];
        foreach ($settings as $setting) {
            $settingsFormat[$setting->get('key')] = $setting->get('value');
        }
        return $this->outputArray($settingsFormat);
    }
}