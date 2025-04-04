<?php
require_once dirname(dirname(__FILE__)) . '/index.class.php';

class CSPectManageManagerController extends CSPectBaseManagerController
{

    public function process(array $scriptProperties = []): void
    {
    }

    public function getPageTitle(): string
    {
        return $this->modx->lexicon('cspect.manage.page_title');
    }

    public function loadCustomCssJs(): void
    {
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/widgets/context/vtabs.js');
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/widgets/context/panel.js');
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/widgets/context/window.js');
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/widgets/directive/grid.js');
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/widgets/directive/window.js');
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/widgets/source/grid.js');
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/widgets/source/window.js');
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/widgets/violation/grid.js');
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/widgets/violation/window.js');
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/widgets/manage.panel.js');
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/sections/manage.js');
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/utils/combos.js');
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/utils/griddraganddrop.js');

        $this->addHtml(
            '
            <script type="text/javascript">
                Ext.onReady(function() {
                    MODx.load({ xtype: "cspect-page-manage"});
                });
            </script>
        '
        );
    }

    public function getTemplateFile(): string
    {
        return $this->cspect->getOption('templatesPath') . 'manage.tpl';
    }

}
