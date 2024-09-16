<?php
abstract class CSPectBaseManagerController extends modExtraManagerController {
    /** @var \CSPect\CSPect $cspect */
    public $cspect;

    public function initialize(): void
    {
        if (!$this->modx->version) {
            $this->modx->getVersionData();
        }
        $version = (int) $this->modx->version['version'];
        if ($version > 2) {
            $this->cspect = $this->modx->services->get('cspect');
        } else {
            $corePath = $this->modx->getOption('cspect.core_path', null, $this->modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/cspect/');
            $this->cspect = $this->modx->getService(
                'cspect',
                'CSPect',
                $corePath . 'model/cspect/',
                [
                    'core_path' => $corePath
                ]
            );
        }


        $this->addCss($this->cspect->getOption('cssUrl') . 'mgr.css');
        $this->addJavascript($this->cspect->getOption('jsUrl') . 'mgr/cspect.js');

        $this->addHtml('
            <script type="text/javascript">
                Ext.onReady(function() {
                    cspect.config = '.$this->modx->toJSON($this->cspect->config).';
                    cspect.config.modxVersion = '.$version.';
                });
            </script>
        ');

        parent::initialize();
    }

    public function getLanguageTopics(): array
    {
        return array('cspect:default');
    }

    public function checkPermissions(): bool
    {
        return true;
    }
}
