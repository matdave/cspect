<?php

namespace CSPect\v2\Processors\Contexts;


class Update extends \modProcessor
{
    public function getLanguageTopics() {
        return ['cspect:default'];
    }
    public function process()
    {
        $key = $this->getProperty('context_key');
        if ($key === 'mgr') {
            $class = 'modSystemSetting';
        } else {
            $class = 'modContextSetting';
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
        if ($class === 'modContextSetting') {
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
            if ($class === 'modContextSetting') {
                $obj->set('context_key', $key);
            }
        }
        $obj->set('value', $value);
        $obj->save();
    }
}