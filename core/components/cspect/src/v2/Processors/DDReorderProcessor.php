<?php

namespace CSPect\v2\Processors;

use modObjectProcessor;

abstract class DDReorderProcessor extends modObjectProcessor
{
    public $languageTopics = ['cspect:default'];
    public $rankColumn = 'rank';
    public $staticFilter = [];

    public function process()
    {
        $idItem = (int)$this->getProperty('idItem');
        $oldIndex = (int)$this->getProperty('oldIndex');
        $newIndex = (int)$this->getProperty('newIndex');
        $offset = 0;
        if ($newIndex < 0) {
            $offset = 1 + $newIndex * -1;
        }

        $where = [];
        foreach ($this->staticFilter as $filterName) {
            $filterValue = (int)$this->getProperty($filterName);

            if (empty($filterValue)) {
                return $this->failure($this->modx->lexicon('cspect.err.' . $filterName . '_ns'));
            }

            $where[$filterName] = $filterValue;
        }

        $where['id:!='] = $idItem;

        $items = $this->modx->newQuery($this->classKey);
        if ($oldIndex < $newIndex) {
            $where[$this->rankColumn . ':>'] = $oldIndex;
            $where[$this->rankColumn . ':<='] = $newIndex;
            $items->sortby($this->rankColumn, 'DESC');
        } else {
            $where[$this->rankColumn . ':<'] = $oldIndex;
            $where[$this->rankColumn . ':>='] = $newIndex;
            $items->sortby($this->rankColumn, 'ASC');
        }
        $items->where($where);

        $itemsColumn = $this->modx->getIterator($this->classKey, $items);
        $rank = $newIndex;

        if ($oldIndex > $newIndex) {
            foreach ($itemsColumn as $item) {
                $rank++;
                $item->set($this->rankColumn, $rank + $offset);
                $item->save();
            }
        } else {
            foreach ($itemsColumn as $item) {
                $rank--;
                $item->set($this->rankColumn, $rank + $offset);
                $item->save();
            }
        }

        $itemObject = $this->modx->getObject($this->classKey, $idItem);
        $itemObject->set($this->rankColumn, $newIndex + $offset);
        $itemObject->save();

        return $this->success('', $itemObject);
    }

}