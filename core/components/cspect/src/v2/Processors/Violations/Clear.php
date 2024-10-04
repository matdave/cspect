<?php

namespace CSPect\v2\Processors\Violations;

use modProcessor;

class Clear extends modProcessor
{
    public function process()
    {
        $createdOn = $this->getProperty('created_on');
        $where = [];
        if (!empty($createdOn)) {
            $where['created_on:<'] = $createdOn;
        }
        $this->modx->removeCollection('CSPViolation', $where);
        return $this->success();
    }
}