<?php
require_once dirname(dirname(__FILE__)) . '/index.class.php';

class CSPectDirectiveManagerController extends CSPectBaseManagerController
{

    public function process(array $scriptProperties = []): void
    {
    }

    public function getPageTitle(): string
    {
        return $this->modx->lexicon('cspect.manage.directive');
    }

    public function loadCustomCssJs(): void
    {
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/widgets/directive/panel.js');
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/sections/directive.js');
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/utils/combos.js');
        $this->addLastJavascript($this->cspect->getOption('jsUrl') . 'mgr/utils/griddraganddrop.js');

        if (!$this->loadDirective()) {
            $this->modx->sendRedirect($this->modx->getOption('manager_url') . '?a=manage&namespace=cspect');
        }

        $this->addHtml(
            '
            <script type="text/javascript">
                Ext.onReady(function() {
                    MODx.load({ xtype: "cspect-page-directive"});
                });
            </script>
        '
        );
    }

    public function loadDirective(): bool
    {
        $id = (int) $_GET['id'];
        if (!empty($id)) {
            if ($this->version < 3) {
                $directive = $this->modx->getObject('CSPDirective', $id);
            } else {
                $directive = $this->modx->getObject(\CSPect\Model\CSPDirective::class, $id);
            }
            if ($directive) {
                $this->modx->lexicon->load('cspect:default');
                $this->addHtml('<script type="text/javascript">cspect.directive = ' . $directive->toJSON() . ';</script>');
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
