<?php

namespace CSPect\Traits\Processors;

trait Rank
{
    public function beforeSave()
    {
        $rank = $this->object->get('rank');
        if (empty($rank)) {
            $c = $this->modx->newQuery($this->classKey);
            $c->sortby('rank', 'DESC');
            $c->limit(1);
            $highest = $this->modx->getObject($this->classKey, $c);
            $this->object->set('rank', $highest->get('rank') + 1);
        } else {
            $collision = $this->modx->getObject($this->classKey, ['rank' => $rank, 'id:!=' => $this->object->get('id')]);
            if (!empty($collision)) {
                $c = $this->modx->newQuery($this->classKey);
                $c->where('rank', '>=', $rank);
                $c->sortby('rank', 'ASC');
                $update = $this->modx->getIterator($this->classKey, $c);
                foreach ($update as $item) {
                    $rank++;
                    $item->set('rank', $rank);
                    $item->save();
                }
            }
        }
        return parent::beforeSave();
    }

    public function beforeRemove()
    {
        $rank = $this->object->get('rank');
        $c = $this->modx->newQuery($this->classKey);
        $c->where(['rank:>' => $rank]);
        $c->sortby('rank', 'ASC');
        $update = $this->modx->getIterator($this->classKey, $c);
        foreach ($update as $item) {
            $item->set('rank', $rank);
            $item->save();
            $rank++;
        }
        return parent::beforeRemove();
    }
}