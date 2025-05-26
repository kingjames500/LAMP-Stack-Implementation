<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'lamp-server.mysql.database.azure.com'; // Or your Azure DB host
$dbname = 'portal';
$username = 'tkytvubhla';
$password = 'oSENi$ZDRs3b3iR6';
$options = [
    PDO::MYSQL_ATTR_SSL_CA => __DIR__ . '../cert/DigiCertGlobalRootCA.crt.pem',
    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => true,
];

try {
    $pdo = new PDO("mysql:host=$host", $username, $password, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create Database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`; USE `$dbname`;");

    // Create judges table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `judges` (
            id VARCHAR(36) PRIMARY KEY DEFAULT(UUID()),
            username VARCHAR(20) NOT NULL,
            display_name VARCHAR(25) NOT NULL
        );
    ");

    // Seed judges
    $pdo->exec("
        INSERT IGNORE INTO judges (username, display_name) VALUES 
        ('Judge Simon', 'Simon'),
        ('Rose Waiyaki', 'Rose W'),
        ('Smith Lee', 'Smith');
    ");

    // Create users table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `users` (
            id VARCHAR(36) PRIMARY KEY DEFAULT(UUID()),
            full_name VARCHAR(100) NOT NULL
        );
    ");

    // Seed users
    $pdo->exec("
        INSERT IGNORE INTO users (full_name) VALUES
        ('TEST1'),
        ('test2'),
        ('John Does');
    ");

    // Create scores table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `scores` (
            id VARCHAR(36) PRIMARY KEY DEFAULT(UUID()),
            judge_id VARCHAR(36),
            user_id VARCHAR(36),
            points INT CHECK (points >= 0 AND points <= 100),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (judge_id) REFERENCES judges(id),
            FOREIGN KEY (user_id) REFERENCES users(id),
            UNIQUE (judge_id, user_id)
        );
    ");

    echo json_encode(["status" => "success", "message" => "Migration completed successfully."]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}