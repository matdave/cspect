<?php
require_once dirname(dirname(__FILE__)) . '/index.class.php';

class CSPectSourceManagerController extends CSPectBaseManagerController
{

    public function process(array $scriptProperties = []): void
    {
    }

    public function getPageTitle(): string
    {
        return $this->modx->lexicon('cspect.manage.source');
    }

    public function loadCustomCssJs(): void
    {
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/widgets/source/panel.js');
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/widgets/source/context/grid.js');
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/widgets/source/context/window.js');
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/widgets/source/directive/grid.js');
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/widgets/source/directive/window.js');
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/sections/source.js');
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/utils/combos.js');
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/utils/griddraganddrop.js');

        if (!$this->loadSource()) {
            $this->modx->sendRedirect($this->modx->getOption('manager_url') . '?a=manage&namespace=cspect');
        }

        if ($this->version < 3) {
            $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/utils/breadcrumbs.js');
        }

        $this->addHtml(
            '
            <script type="text/javascript">
                Ext.onReady(function() {
                    MODx.load({ xtype: "cspect-page-source"});
                });
            </script>
        '
        );
    }

    public function loadSource(): bool
    {
        $id = (int) $_GET['id'];
        if (!empty($id)) {
            if ($this->version < 3) {
                $source = $this->modx->getObject('CSPSource', $id);
            } else {
                $source = $this->modx->getObject(\CSPect\Model\CSPSource::class, $id);
            }
            if ($source) {
                $this->modx->lexicon->load('cspect:default');
                $this->addHtml('<script type="text/javascript">cspect.source = ' . $source->toJSON() . ';</script>');
                return true;
            }
        }
        return false;
    }

    public function getTemplateFile(): string
    {
        return $this->cspect->getOption('templatesPath') . 'manage.tpl';
    }

}
