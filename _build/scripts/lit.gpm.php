<?php

use MODX\Revolution\modSystemSetting;
use MODX\Revolution\modX;

return new class() {
    protected modX $modx;
    protected $action;
    public function __invoke(modX $modx, $action)
    {
        $this->modx = $modx;
        $this->action = $action;
        $this->run();
        return true;
    }

    private function run(): void
    {
        $setting = $this->modx->getObject(modSystemSetting::class, ['key' => 'cspect.lit']);
        if (!$setting) {
            $setting = $this->modx->newObject(modSystemSetting::class);
            $setting->fromArray([
                'key' => 'cspect.lit',
                'namespace' => 'cspect',
                'xtype' => 'textfield',
                'area' => 'cspect',
                'editedon' => time(),
                'editedby' => 0,
            ]);
        }
        $setting->set('value', time());
        $setting->save();
    }
};