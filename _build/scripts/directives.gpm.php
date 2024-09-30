<?php

use MODX\Revolution\modX;
use CSPect\Model\CSPDirective;

return new class() {
    protected modX $modx;
    protected $action;
    public function __invoke(modX $modx, $action)
    {
        $this->modx = $modx;
        $this->action = $action;
        /* if ($this->action !== 'install') {
            return true;
        } */
        $this->run();
        return true;
    }

    private function run(): void
    {
        $sources = [
            'default-src',
            'font-src',
            'img-src',
            'script-src',
            'style-src',
        ];
        $rank = 0;
        foreach ($sources as $source) {
            $this->createSource($source, $rank);
            $rank++;
        }
    }

    private function createSource($source, $rank): void
    {
        $obj = $this->modx->getObject(CSPDirective::class, ['name' => $source]);
        if (!$obj) {
            $obj = $this->modx->newObject(CSPDirective::class);
            $obj->set('name', $source);
            $obj->set('rank', $rank);
            $obj->save();
        }
    }
};