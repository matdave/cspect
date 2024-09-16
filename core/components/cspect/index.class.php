<?php
abstract class CspEctBaseManagerController extends modExtraManagerController {
    /** @var \CspEct\CspEct $cspect */
    public $cspect;

    public function initialize(): void
    {
        $this->cspect = $this->modx->services->get('cspect');

        $this->addCss($this->cspect->getOption('cssUrl') . 'mgr.css');
        $this->addJavascript($this->cspect->getOption('jsUrl') . 'mgr/cspect.js');

        $this->addHtml('
            <script type="text/javascript">
                Ext.onReady(function() {
                    cspect.config = '.$this->modx->toJSON($this->cspect->config).';
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
