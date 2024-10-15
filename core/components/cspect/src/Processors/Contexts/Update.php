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
        foreach ($settings as $setting) {
            $this->saveSetting($class, $key, $setting);
        }
        return $this->success();
    }

    private function saveSetting($class, $key, $setting)
    {
        $value = $this->getProperty($setting);
        if ($value === $this->modx->lexicon('cspect.context.inherited')) {
            return;
        }
        $where = ['key' => 'cspect.'.$setting];
        if ($class === modContextSetting::class) {
            $where['context_key'] = $key;
        }
        $obj = $this->modx->getObject($class, $where);
        if (empty($value)) {
            if (!empty($obj)) {
                $obj->remove();
            }
            return;
        }
        if (empty($obj)) {
            $obj = $this->modx->newObject($class);
            $obj->set('key', 'cspect.'.$setting);
            if ($class === modContextSetting::class) {
                $obj->set('context_key', $key);
            }
        }
        $obj->set('value', $value);
        $obj->save();
    }
}