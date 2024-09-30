<?php
header('X-Content-Type-Options: "nosniff"');
require_once dirname(__FILE__, 4) . '/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';

/**
 * @var $database_dsn string
 * @var $database_user string
 * @var $database_password string
 * @var $table_prefix string
 */
$data = file_get_contents('php://input');
if (empty($data)) {
    echo json_encode(['success' => false]);
    exit;
}
$data = json_decode($data, true);
// sanitize the data
if (!function_exists('cleanchars')) {
    function cleanchars($string)
    {
        if (is_array($string)) {
            return array_map('cleanchars', $string);
        }
        return htmlspecialchars($string);
    }
}
$data = array_map('cleanchars', $data);
$pdo = new \PDO($database_dsn, $database_user, $database_password);
$stmt = $pdo->prepare("SELECT `value` FROM {$table_prefix}system_settings WHERE `key` = 'default_context'");
$stmt->execute();
$default_context = $stmt->fetchColumn();
$context_key = $default_context;
if (isset($data['url'])) {
    // Report from the browser
    $parsed_url = parse_url($data['url']);
    $domain = $parsed_url['host'] ?? '';
    $stmt = $pdo->prepare("SELECT context_key FROM {$table_prefix}context_setting WHERE `value` LIKE :domain AND `key` = 'site_url'");
    $stmt->execute(['domain' => "%$domain%"]);
    $context = $stmt->fetchColumn();
    if (!empty($context)) {
        $context_key = $context;
    }
    $report = [
        'context_key' => $context_key,
        'age' => $data['age'] ?? 0,
        'type' => $data['type'] ?? '',
        'url' => $data['url'] ?? '',
        'user_agent' => $data['user_agent'] ?? '',
        'body' => json_encode($data['body']) ?? '',
    ];
} elseif (isset($data['csp-report'])) {
    // Report from the server
    $report = [
        'context_key' => $context_key,
        'age' => $data['csp-report']['age'] ?? 0,
        'type' => 'csp-violation',
        'url' => $data['csp-report']['document-uri'] ?? '',
        'user_agent' => $data['csp-report']['user_agent'] ?? '',
        'body' => json_encode($data['csp-report']) ?? '',
    ];
} else {
    $report = [
        'context_key' => $context_key,
        'age' => 0,
        'type' => 'unknown',
        'url' => '',
        'user_agent' => '',
        'body' => json_encode($data) ?? '[]',
    ];
}

$statement = $pdo->prepare("INSERT INTO {$table_prefix}cspect_violation (context_key, age, type, url, user_agent, body) VALUES (:context_key, :age, :type, :url, :user_agent, :body)");

$statement->execute($report);

echo json_encode(['success' => true]);

/**
 * @TODO needs testing for handling multiple reports and security
 * @TODO needs to detect context_key from the request
 */