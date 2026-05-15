<?php
/**
 * Resolve creating db tables
 *
 * THIS RESOLVER IS AUTOMATICALLY GENERATED, NO CHANGES WILL APPLY
 *
 * @package cspect
 * @subpackage build
 *
 * @var mixed $object
 * @var modX $modx
 * @var array $options
 */

if ($object->xpdo) {
    $modx =& $object->xpdo;
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $modelPath = $modx->getOption('cspect.core_path', null, $modx->getOption('core_path') . 'components/cspect/') . 'model/';
            
            $modx->addPackage('cspect', $modelPath, null);


            $manager = $modx->getManager();

            $manager->createObjectContainer('CSPDirective');
            $manager->createObjectContainer('CSPSource');
            $manager->createObjectContainer('CSPSourceDirective');
            $manager->createObjectContainer('CSPSourceContext');
            $manager->createObjectContainer('CSPViolation');

            break;
    }
}

return true;