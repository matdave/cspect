<?php
header('X-Content-Type-Options: "nosniff"');
require_once dirname(__FILE__, 4) . '/config.core.php';
require_once dirname(__FILE__) . '/report.class.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';

/**
 * @var $database_dsn string
 * @var $database_user string
 * @var $database_password string
 * @var $table_prefix string
 */
$data = file_get_contents('php://input');
if (empty($data)) {
    print_r(['success' => false]);
    die();
}
$data = json_decode($data, true);
$pdo = new \PDO($database_dsn, $database_user, $database_password);

$report = new Report($pdo, $data, $table_prefix);
print_r($report->run());
