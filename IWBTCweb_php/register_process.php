<?php
// 注册处理逻辑
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 获取表单数据
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // 验证密码是否一致
    if ($password != $confirm_password) {
        echo '两次输入的密码不一致';
        exit;
    }
    
    // 验证密码强度
    if (strlen($password) < 6) {
        echo '密码长度至少为6位';
        exit;
    }
    
    try {
        // 连接数据库
        $pdo = get_db_connection();
        
        // 检查用户名是否已存在
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo '用户名已存在';
            exit;
        }
        
        // 检查邮箱是否已存在
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo '邮箱已被注册';
            exit;
        }
        
        // 生成密码哈希
        $password_hash = password_hash_custom($password);
        
        // 生成UUID
        $uuid = generate_uuid();
        
        // 默认角色为普通用户（role_id = 2）
        $role_id = 2;
        
        // 插入用户数据
        $stmt = $pdo->prepare("INSERT INTO users (uuid, username, email, password_hash, role_id, status) VALUES (:uuid, :username, :email, :password_hash, :role_id, 'active')");
        $stmt->bindParam(':uuid', $uuid);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password_hash', $password_hash);
        $stmt->bindParam(':role_id', $role_id);
        
        if ($stmt->execute()) {
            echo '注册成功！<a href="login.php">去登录</a>';
        } else {
            echo '注册失败，请稍后重试';
        }
        
    } catch (PDOException $e) {
        echo '数据库错误: ' . $e->getMessage();
    }
}
?>