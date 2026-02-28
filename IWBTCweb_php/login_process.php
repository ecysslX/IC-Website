<?php
// 登录处理逻辑
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 获取表单数据
    $username = $_POST['username'];
    $password = $_POST['password'];
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    
    try {
        // 连接数据库
        $pdo = get_db_connection();
        
        // 查询用户信息
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $username); // 允许使用邮箱登录
        $stmt->execute();
        $user = $stmt->fetch();
        
        // 验证用户
        if ($user && password_verify_custom($password, $user['password_hash'])) {
            // 检查用户状态
            if ($user['status'] != 'active') {
                echo '账号已被禁用';
                exit;
            }
            
            // 登录成功，更新最后登录时间
            $stmt = $pdo->prepare("UPDATE users SET last_login_at = CURRENT_TIMESTAMP WHERE id = :id");
            $stmt->bindParam(':id', $user['id']);
            $stmt->execute();
            
            // 记录登录日志
            $stmt = $pdo->prepare("INSERT INTO login_logs (user_id, ip_address, user_agent, status) VALUES (:user_id, :ip_address, :user_agent, 'success')");
            $stmt->bindParam(':user_id', $user['id']);
            $stmt->bindParam(':ip_address', $ip_address);
            $stmt->bindParam(':user_agent', $user_agent);
            $stmt->execute();
            
            // 启动会话
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role_id'] = $user['role_id'];
            $_SESSION['uuid'] = $user['uuid'];
            
            // 跳转到首页
            header('Location: home.php');
            exit;
        } else {
            // 登录失败，不记录日志（因为user_id为空）
            echo '登录失败，请检查用户名和密码';
        }
    } catch (PDOException $e) {
        echo '数据库错误: ' . $e->getMessage();
    }
}
?>