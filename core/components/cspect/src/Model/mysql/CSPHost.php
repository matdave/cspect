<?php
namespace CSPect\Model\mysql;

use xPDO\xPDO;

class CSPHost extends \CSPect\Model\CSPHost
{

    public static $metaMap = array (
        'package' => 'CSPect\\Model\\',
        'version' => '3.0',
        'table' => 'cspect_host',
        'tableMeta' => 
        array (
            'engine' => 'InnoDB',
        ),
        'fields' => 
        array (
            'name' => '',
        ),
        'fieldMeta' => 
        array (
            'name' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '127',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
            ),
        ),
        'indexes' => 
        array (
            'name' => 
            array (
                'alias' => 'name',
                'primary' => false,
                'unique' => true,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'name' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
        ),
        'aggregates' => 
        array (
            'Sources' => 
            array (
                'class' => 'CSPect\\Model\\CSPHostSource',
                'local' => 'id',
                'foreign' => 'host',
                'cardinality' => 'many',
                'owner' => 'local',
            ),
            'Contexts' => 
            array (
                'class' => 'CSPect\\Model\\CSPHostContext',
                'local' => 'id',
                'foreign' => 'host',
                'cardinality' => 'many',
                'owner' => 'local',
            ),
        ),
    );

}
