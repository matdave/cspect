<?php

namespace CSPect\Processors\Violations;

use CSPect\Model\CSPViolation;
use MODX\Revolution\Processors\Processor;

class Clear extends Processor
{
    public function process()
    {
        $createdOn = $this->getProperty('created_on');
        $where = [];
        if (!empty($createdOn)) {
            $where['created_on:<'] = $createdOn;
        }
        $this->modx->removeCollection(CSPViolation::class, $where);
        return $this->success();
    }
}