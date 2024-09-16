<?php
/**
 * @package cspect
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/csphost.class.php');
class CSPHost_mysql extends CSPHost {}
?>