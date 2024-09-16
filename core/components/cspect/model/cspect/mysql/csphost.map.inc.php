<?php
/**
 * @package cspect
 */
$xpdo_meta_map['CSPHost']= array (
  'package' => 'cspect',
  'version' => '2.0',
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
      'class' => 'CSPHostSource',
      'local' => 'id',
      'foreign' => 'host',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'Contexts' => 
    array (
      'class' => 'CSPHostContext',
      'local' => 'id',
      'foreign' => 'host',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
