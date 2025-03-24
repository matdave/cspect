<?php

class Report
{
    private \PDO $pdo;
    private array $data;

    private string $table_prefix = 'modx_';

    private array $defaultContexts = ['web'];

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
        $this->defaultContexts = $this->getDefaultContext();
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
        $stmt = $this->pdo->prepare("SELECT `value` FROM {$this->table_prefix}system_settings WHERE `key` = 'cspect.default_contexts'");
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return explode(',', $result);
    }

    private function saveReport($report): bool
    {
        if (empty($report['url'])) {
            return $this->legacyReport($report);
        }
        $parsedUrl = parse_url($report['url']);
        $contexts = $this->getContext($parsedUrl['host'] ?? '');
        $userAgent = $this->getUserAgent($report);
        foreach ($contexts as $context) {
            $this->save([
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
        return true;
    }

    private function legacyReport($report): bool
    {
        if (empty($report['csp-report'])) {
            return $this->save([
                'context_key' => $this->defaultContexts[0],
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
                'context_key' => $this->defaultContexts[0],
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
            return $this->defaultContexts;
        }
        $stmt = $this->pdo->prepare("SELECT context_key FROM {$this->table_prefix}context_setting WHERE `value` LIKE :domain AND `key` = 'site_url' AND `context_key` != 'mgr'");
        $stmt->execute(['domain' => "%$domain%"]);
        $contexts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($contexts)) {
            return $this->defaultContexts;
        }
        $results = [];
        foreach ($contexts as $row) {
            $results = $row['context_key'];
        }
        return $results;
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
