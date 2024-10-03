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
            $contexts = $modx->getOption('cspect.default_contexts', null, 'web');
            $contexts = explode(',', $contexts);
            $rank = 1;
            foreach ($sources as $source) {
                $obj = $modx->getObject('CSPSource', ['name' => $source]);
                if (!$obj) {
                    $obj = $modx->newObject('CSPSource');
                    $obj->set('name', $source);
                    $obj->set('rank', $rank);
                    $obj->save();
                    foreach ($contexts as $context) {
                        $cobj = $modx->newObject('CSPSourceContext');
                        $cobj->set('source', $obj->get('id'));
                        $cobj->set('context_key', $context);
                        $cobj->save();
                    }
                }
                $rank++;
            }
            break;
    }
}
