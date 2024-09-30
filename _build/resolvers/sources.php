<?php

if ($object->xpdo) {
    /** @var modX $modx */
    $modx =& $object->xpdo;

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            $sources = [
                'self',
                'unsafe-inline',
                'unsafe-eval',
                'data:',
                'blob:',
            ];
            $rank = 1;
            foreach ($sources as $source) {
                $obj = $modx->getObject('CSPSource', ['name' => $source]);
                if (!$obj) {
                    $obj = $modx->newObject('CSPSource');
                    $obj->set('name', $source);
                    $obj->set('rank', $rank);
                    $obj->save();
                }
                $rank++;
            }
            break;
    }
}
