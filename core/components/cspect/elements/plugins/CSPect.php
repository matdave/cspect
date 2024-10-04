<?php
/**
 * CSPect
 *
 * @package cpect
 * @subpackage core
 *
 * @property \modX $modx
 * @property array $scriptProperties
 */

$event = $modx->event->name;

if (!$modx->version) {
    $modx->getVersionData();
}

$version = '';
if ($modx->version['version'] < 3) {
    $version = '\\v2';
    $cspect = $modx->getService(
        'cspect',
        'CSPect',
        $modx->getOption(
            'cspect.core_path',
            null,
            $modx->getOption(
                'core_path',
                null,
                MODX_CORE_PATH
            ) . 'components/cspect/'
        ) . 'model/cspect/'
    );
} else {
    $cspect = new \CSPect\CSPect($modx);
}

$class = 'CSPect' . $version . '\\Events\\' . $event;

if (class_exists($class)) {
    $event = new $class($cspect, $scriptProperties);
    $event->run();
} else {
    $modx->log(\modX::LOG_LEVEL_ERROR, 'Could not find event class: ' . $class
        . ' for event: ' . $modx->event->name);
}