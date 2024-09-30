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

$cspect = new \CSPect\CSPect($modx);

$event = $modx->event->name;

$class = 'CSPect\\Events\\' . $event;

if (class_exists($class)) {
    $event = new $class($cspect, $scriptProperties);
    $event->run();
} else {
    $modx->log(\modX::LOG_LEVEL_ERROR, 'Could not find event class: ' . $class
        . ' for event: ' . $modx->event->name);
}