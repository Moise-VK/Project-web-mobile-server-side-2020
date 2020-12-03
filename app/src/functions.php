<?php

    use Doctrine\DBAL\Connection;

    function getDBConnection() : Connection {
        $connectionParams = [
            'host' => DB_HOST,
            'dbname' => DB_NAME,
            'user' => DB_USER,
            'password' => DB_PASS,
            'driver' => 'pdo_mysql',
            'charset' => 'utf8mb4'
        ];
        $connection = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
        try {
            $connection->connect();
            return $connection;
        } catch (\Doctrine\DBAL\Exception\ConnectionException $e) {
            echo 'Could not connect to database.';
            exit;
        }
    }
