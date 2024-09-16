<?php

use MODX\Revolution\modX;
use CSPect\Model\CSPSource;

return new class() {
    protected modX $modx;
    protected $action;
    public function __invoke(modX $modx, $action)
    {
        $this->modx = $modx;
        $this->action = $action;
        if ($this->action !== 'install') {
            return true;
        }
        $this->run();
        return true;
    }

    private function run(): void
    {
        $hosts = [
            'self',
            'unsafe-inline',
            'unsafe-eval',
            'data:',
            'blob:',
        ];
        $rank = 0;
        foreach ($hosts as $host) {
            $this->createHost($host, $rank);
            $rank++;
        }
    }

    private function createHost($host, $rank): void
    {
        $obj = $this->modx->getObject(CSPSource::class, ['name' => $host]);
        if (!$obj) {
            $obj = $this->modx->newObject(CSPSource::class);
            $obj->set('name', $host);
            $obj->set('rank', $rank);
            $obj->save();
        }
    }
};