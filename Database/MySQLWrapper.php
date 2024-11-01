<?php

namespace Database;

use mysqli;
use Helpers\Settings;

class MySQLWrapper extends mysqli {
    public function __construct(?string $hostname = 'localhost', string $username = null, string $password = null, string $database = null, int $port = null, string $socket = null)
    {
        // ERROR: エラーメッセージの自動表示. STRICT: 例外をスローするようになる
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $username = $username??Settings::env('DATABASE_USER');
        $password = $password??Settings::env('DATABASE_USER_PASSWORD');
        $database = $database??Settings::env('DATABASE_NAME');

        parent::__construct($hostname, $username, $password, $database, $port, $socket);

    }

    public function getDatabaseName(): string {
        return $this->query("Select database() AS the_db")->fetch_row()[0];
    }

    
    public function prepareAndFetchAll(string $prepareQuery, string $types, array $data): ?array{
        $this->typesAndDataValidationPass($types, $data);

        $stmt = $this->prepare($prepareQuery);
        if(count($data) > 0) $stmt->bind_param($types, ...$data);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result === false) throw new Exception(sprintf('Error fetching data on query %s', $prepareQuery));

        // 連想モードを使用して、列名も取得します。
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function prepareAndExecute(string $prepareQuery, string $types, array $data): bool{
        $this->typesAndDataValidationPass($types, $data);

        $stmt = $this->prepare($prepareQuery);
        if(count($data) > 0) $stmt->bind_param($types, ...$data);
        return $stmt->execute();
    }

    private function typesAndDataValidationPass(string $types, array $data): void{
        if (strlen($types) !== count($data)) throw new Exception(sprintf('Type and data must equal in length %s vs %s', strlen($types), count($data)));
    }
}