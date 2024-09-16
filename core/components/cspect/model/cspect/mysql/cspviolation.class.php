<?php
/**
 * @package cspect
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/cspviolation.class.php');
class CSPViolation_mysql extends CSPViolation {}
?>