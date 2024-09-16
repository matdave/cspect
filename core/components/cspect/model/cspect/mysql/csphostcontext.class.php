<?php
/**
 * @package cspect
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/csphostcontext.class.php');
class CSPHostContext_mysql extends CSPHostContext {}
?>