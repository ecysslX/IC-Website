<?php 
// 检查登录状态
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// 连接数据库获取用户角色信息
require_once 'config.php';
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$uuid = $_SESSION['uuid'];

// 从数据库获取最新的用户信息，包括角色ID
try {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("SELECT role_id FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch();
    $role_id = $user['role_id'];
    
    // 获取角色名称
    $stmt = $pdo->prepare("SELECT name FROM roles WHERE id = :role_id");
    $stmt->bindParam(':role_id', $role_id);
    $stmt->execute();
    $role = $stmt->fetch();
    $role_name = $role['name'] == 'admin' ? '管理员' : '普通用户';
} catch (PDOException $e) {
    $role_name = '普通用户';
}

// 退出登录处理
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header('Location: login.php');
    exit;
}

include 'sidebar.php'; 
?>

<!-- 个人资料页面 -->
<div class="tabcontent" id="profile">
    <div class="login_content">
        <h1>个人资料</h1>
        <div class="profile-info">
            <div class="info-item">
                <span class="label">用户名：</span>
                <span class="value"><?php echo htmlspecialchars($username); ?></span>
            </div>
            <div class="info-item">
                <span class="label">用户ID：</span>
                <span class="value"><?php echo htmlspecialchars($user_id); ?></span>
            </div>
            <div class="info-item">
                <span class="label">用户UUID：</span>
                <span class="value"><?php echo htmlspecialchars($uuid); ?></span>
            </div>
            <div class="info-item">
                <span class="label">用户角色：</span>
                <span class="value"><?php echo htmlspecialchars($role_name); ?></span>
            </div>
        </div>
        <div class="form-group">
            <a href="?action=logout" class="logout-btn">退出登录</a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>