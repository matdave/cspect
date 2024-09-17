<?php
namespace CSPect\Model\mysql;

use xPDO\xPDO;

class CSPSource extends \CSPect\Model\CSPSource
{

    public static $metaMap = array (
        'package' => 'CSPect\\Model\\',
        'version' => '3.0',
        'table' => 'cspect_source',
        'tableMeta' => 
        array (
            'engine' => 'InnoDB',
        ),
        'fields' => 
        array (
            'name' => '',
            'rank' => 0,
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
            'rank' => 
            array (
                'dbtype' => 'int',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => false,
                'default' => 0,
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
            'rank' => 
            array (
                'alias' => 'rank',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'rank' => 
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
            'Directives' => 
            array (
                'class' => 'CSPect\\Model\\CSPSourceDirective',
                'local' => 'id',
                'foreign' => 'host',
                'cardinality' => 'many',
                'owner' => 'local',
            ),
            'Contexts' => 
            array (
                'class' => 'CSPect\\Model\\CSPSourceContext',
                'local' => 'id',
                'foreign' => 'host',
                'cardinality' => 'many',
                'owner' => 'local',
            ),
        ),
    );

}
