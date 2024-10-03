<?php

if ($object->xpdo) {
    /** @var modX $modx */
    $modx =& $object->xpdo;

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            $sources = [
                'default-src',
                'font-src',
                'img-src',
                'script-src',
                'style-src',
            ];
            foreach ($sources as $source) {
                $obj = $modx->getObject('CSPDirective', ['name' => $source]);
                if (!$obj) {
                    $obj = $modx->newObject('CSPDirective');
                    $obj->set('name', $source);
                    $obj->set('rank', $rank);
                    $obj->save();
                }
                $rank++;
            }
            break;
    }
}
