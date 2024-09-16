<?php

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use CSPect\CSPect as CSPectBase;

class CSPect extends CSPectBase
{
    public function __construct(&$modx, array $options = [])
    {
        $corePath = $modx->getOption('cspect.core_path', $options, $modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/cspect/');
        $assetsUrl = $modx->getOption('cspect.assets_url', $options, $modx->getOption('assets_url', null, MODX_ASSETS_URL) . 'components/cspect/');

        /* loads some default paths for easier management */
        $options = array_merge([
            'modelPath' => $corePath . 'model/',
            'connectorUrl' => $assetsUrl . 'connector.php',
        ], $options);
        parent::__construct($modx, $options);
    }
    public function addPackage()
    {
        $this->modx->addPackage('cspect', $this->getOption('modelPath'));
    }
}