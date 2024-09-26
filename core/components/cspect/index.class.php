<?php
abstract class CSPectBaseManagerController extends modExtraManagerController {
    /** @var \CSPect\CSPect $cspect */
    public $cspect;
    public int $lit = 0;

    public int $version;

    public function initialize(): void
    {
        if (!$this->modx->version) {
            $this->modx->getVersionData();
        }
        $this->version = (int) $this->modx->version['version'];
        if ($this->version > 2) {
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

        $this->lit = $this->modx->getOption('cspect.lit', null, 0);

        $this->addCss($this->cspect->getOption('cssUrl') . 'mgr.css');
        $this->addJavascript($this->cspect->getOption('jsUrl') . 'mgr/cspect.js');

        $this->addHtml('
            <script type="text/javascript">
                Ext.onReady(function() {
                    cspect.config = '.$this->modx->toJSON($this->cspect->config).';
                    cspect.config.modxVersion = '.$this->version.';
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

    /**
     * Add an external Javascript file to the head of the
     * page with cache clearing flag
     *
     * @param string $script
     *
     * @return void
     */
    public function addJavascript($script)
    {
        $this->head['js'][] = $script . "?lit=" . $this->lit;
    }

    /**
     * Add an external CSS file to the head of the
     *  page with cache clearing flag
     *
     * @param string $script
     *
     * @return void
     */
    public function addCss($script)
    {
        $this->head['css'][] = $script. "?lit=" . $this->lit;
    }

    /**
     * Add an external Javascript file to the head of the
     *  page with cache clearing flag
     *
     * @param string $script
     *
     * @return void
     */
    public function addLastJavascript($script)
    {
        $this->head['lastjs'][] = $script . "?lit=" . $this->lit;
    }
}
