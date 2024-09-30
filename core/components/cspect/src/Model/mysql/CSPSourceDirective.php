<?php
namespace CSPect\Model\mysql;

use xPDO\xPDO;

class CSPSourceDirective extends \CSPect\Model\CSPSourceDirective
{

    public static $metaMap = array (
        'package' => 'CSPect\\Model\\',
        'version' => '3.0',
        'table' => 'cspect_source_directive',
        'tableMeta' => 
        array (
            'engine' => 'InnoDB',
        ),
        'fields' => 
        array (
            'source' => 0,
            'directive' => 0,
            'value' => NULL,
        ),
        'fieldMeta' => 
        array (
            'source' => 
            array (
                'dbtype' => 'int',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => false,
                'default' => 0,
            ),
            'directive' => 
            array (
                'dbtype' => 'int',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => false,
                'default' => 0,
            ),
            'value' => 
            array (
                'dbtype' => 'text',
                'phptype' => 'string',
                'null' => true,
            ),
        ),
        'indexes' => 
        array (
            'source' => 
            array (
                'alias' => 'source',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'source' => 
                    array (
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ),
                ),
            ),
            'directive' => 
            array (
                'alias' => 'directive',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => 
                array (
                    'directive' => 
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
            'Source' => 
            array (
                'class' => 'CSPect\\Model\\CSPSource',
                'local' => 'source',
                'foreign' => 'id',
                'cardinality' => 'one',
                'owner' => 'foreign',
            ),
            'Directive' => 
            array (
                'class' => 'CSPect\\Model\\CSPDirective',
                'local' => 'directive',
                'foreign' => 'id',
                'cardinality' => 'one',
                'owner' => 'foreign',
            ),
        ),
    );

}
