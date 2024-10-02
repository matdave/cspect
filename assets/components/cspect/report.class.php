<?php

class Report
{
    private \PDO $pdo;
    private array $data;

    private string $table_prefix = 'modx_';

    private string $defaultContext = 'web';

    public function __construct($pdo, $data, $table_prefix)
    {
        $this->pdo = $pdo;
        $this->data = array_map([$this, 'sanitizeData'], $data);
        $this->table_prefix = $table_prefix;
    }

    public function sanitizeData($string)
    {
        if (is_array($string)) {
            return array_map([$this, 'sanitizeData'], $string);
        }
        return htmlspecialchars($string);
    }

    public function run(): array
    {
        $this->defaultContext = $this->getDefaultContext();
        if (!empty($this->data[0]) && is_array($this->data[0])) {
            foreach ($this->data as $report) {
                $this->saveReport($report);
            }
        } else {
            $this->saveReport($this->data);
        }
        return ['success' => true];
    }

    private function getDefaultContext()
    {
        $stmt = $this->pdo->prepare("SELECT `value` FROM {$this->table_prefix}system_settings WHERE `key` = 'default_context'");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    private function saveReport($report): bool
    {
        if (empty($report['url'])) {
            return $this->legacyReport($report);
        }
        $parsedUrl = parse_url($report['url']);
        $context = $this->getContext($parsedUrl['host'] ?? '');
        $userAgent = $this->getUserAgent($report);
        return $this->save([
            'context_key' => $context,
            'age' => $report['age'] ?? 0,
            'type' => $report['type'] ?? '',
            'url' => $report['url'] ?? '',
            'user_agent' => $userAgent,
            'directive' => $report['body']['effectiveDirective'] ?? $report['body']['effective-directive'] ?? 'unknown',
            'blocked' => $report['body']['blockedURL'] ??
                    $report['body']['blocked-url'] ??
                    $report['body']['blockedURI'] ??
                    $report['body']['blocked-uri'] ??
                    '',
            'body' => json_encode($report['body']) ?? '',
        ]);
    }

    private function legacyReport($report): bool
    {
        if (empty($report['csp-report'])) {
            return $this->save([
                'context_key' => $this->defaultContext,
                'age' => 0,
                'type' => 'unknown',
                'url' => '',
                'user_agent' => $this->getUserAgent($report),
                'directive' => 'unknown',
                'blocked' => '',
                'body' => json_encode($report) ?? '[]',
            ]);
        } else {
            return $this->save([
                'context_key' => $this->defaultContext,
                'age' => 0,
                'type' => 'csp-violation',
                'url' => $report['csp-report']['document-uri'] ?? '',
                'user_agent' => $this->getUserAgent($report),
                'directive' => $report['csp-report']['violated-directive'] ?? 'unknown',
                'blocked' => $report['csp-report']['blocked-uri'] ?? '',
                'body' => json_encode($report['csp-report']) ?? '',
            ]);
        }
    }

    private function getContext($domain)
    {
        if (empty($domain)) {
            return $this->defaultContext;
        }
        $stmt = $this->pdo->prepare("SELECT context_key FROM {$this->table_prefix}context_setting WHERE `value` LIKE :domain AND `key` = 'site_url'");
        $stmt->execute(['domain' => "%$domain%"]);
        $context = $stmt->fetchColumn();
        if (empty($context)) {
            return $this->defaultContext;
        }
        return $context;
    }

    private function getUserAgent($report = []): string
    {
        return $report['user_agent'] ?? $_SERVER['HTTP_USER_AGENT'] ?? '';
    }

    private function save($report): bool
    {
        $statement = $this->pdo->prepare("INSERT INTO {$this->table_prefix}cspect_violation (context_key, age, type, url, user_agent, directive, blocked, body) VALUES (:context_key, :age, :type, :url, :user_agent, :directive, :blocked, :body)");

        return $statement->execute($report);
    }
}
