<?php

if ($object->xpdo) {
    /** @var modX $modx */
    $modx =& $object->xpdo;

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $setting = $modx->getObject('modSystemSetting', ['key' => 'cspect.lit']);
            if (!$setting) {
                $setting = $modx->newObject('modSystemSetting');
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
            break;
    }
}
