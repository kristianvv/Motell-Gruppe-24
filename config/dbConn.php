<?php
    function getDbConnection(): PDO {
    $dbConfig = [
        'host' => 'localhost', // or 127.0.0.1
        'dbname' => 'motell',
        'user' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
    ];
    $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
        return new PDO($dsn, $dbConfig['user'], $dbConfig['password'], $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
    register_shutdown_function(function() use (&$pdo) {
        $pdo = null;
    });
}
?>