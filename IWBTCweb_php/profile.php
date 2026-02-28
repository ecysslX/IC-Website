<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

require_once 'config.php';
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$uuid = $_SESSION['uuid'];

try {
    $pdo = get_db_connection();

    $stmt = $pdo->prepare("SELECT role_id FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch();
    $role_id = $user ? $user['role_id'] : 2;

    $stmt = $pdo->prepare("SELECT name FROM roles WHERE id = :role_id");
    $stmt->bindParam(':role_id', $role_id);
    $stmt->execute();
    $role = $stmt->fetch();

    $role_name = ($role && $role['name'] === 'admin') ? '管理员' : '普通用户';
} catch (PDOException $e) {
    $role_name = '普通用户';
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: login.php');
    exit;
}

include 'sidebar.php';
?>

<div class="tabcontent" id="profile">
    <div class="login_content">
        <h1>个人资料</h1>
        <div class="profile-info">
            <div class="info-item">
                <span class="label">用户名：</span>
                <span class="value"><?php echo htmlspecialchars($username); ?></span>
            </div>
            <div class="info-item">
                <span class="label">用户 ID：</span>
                <span class="value"><?php echo htmlspecialchars($user_id); ?></span>
            </div>
            <div class="info-item">
                <span class="label">用户 UUID：</span>
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
