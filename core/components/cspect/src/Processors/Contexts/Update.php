<?php

namespace CSPect\Processors\Contexts;

use MODX\Revolution\modContextSetting;
use MODX\Revolution\modSystemSetting;
use MODX\Revolution\Processors\Processor;

class Update extends Processor
{
    public function getLanguageTopics() {
        return ['cspect:default'];
    }
    public function process()
    {
        $key = $this->getProperty('context_key');
        if ($key === 'mgr') {
            $class = modSystemSetting::class;
        } else {
            $class = modContextSetting::class;
        }

        $settings = ['report_only', 'report_uri', 'report_to', 'reporting_endpoints'];
        $boolean = ['report_only'];
        foreach ($settings as $setting) {
            $this->saveSetting($class, $key, $setting, in_array($setting, $boolean));
        }
        $this->modx->cacheManager->refresh();
        return $this->success();
    }

    private function saveSetting($class, $key, $setting, $boolean = false)
    {
        $value = $this->getProperty($setting);
        if ($value === $this->modx->lexicon('cspect.context.inherited')) {
            return;
        }
        if ($boolean) {
            $value = ($value === 'true' || $value === 'Yes') ? '1' : '0';
        }
        $where = ['key' => 'cspect.'.$setting];
        if ($class === modContextSetting::class) {
            $where['context_key'] = $key;
        }
        $obj = $this->modx->getObject($class, $where);
        if (empty($value) && $value !== '0') {
            if (!empty($obj)) {
                $obj->remove();
            }
            return;
        }
        if (empty($obj)) {
            $obj = $this->modx->newObject($class);
            $obj->set('key', 'cspect.'.$setting);
            $obj->set('namespace', 'cspect');
            if ($class === modContextSetting::class) {
                $obj->set('context_key', $key);
            }
            if ($boolean) {
                $obj->set('xtype', 'combo-boolean');
            }
        }
        $obj->set('value', $value);
        $obj->save();
    }
}