<?php
// 数据库连接配置
define('DB_HOST', 'localhost');
define('DB_PORT', '3307');
define('DB_NAME', 'iwbtc');
define('DB_USER', 'root');
define('DB_PASS', 'explorer394001');

// 连接数据库
function get_db_connection() {
    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        die("数据库连接失败: " . $e->getMessage());
    }
}

// 密码加密函数
function password_hash_custom($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

// 密码验证函数
function password_verify_custom($password, $hash) {
    return password_verify($password, $hash);
}

// 生成UUID函数
function generate_uuid() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}
?>