<?php include 'sidebar.php'; ?>

<!-- 注册页面 -->
<div class="tabcontent" id="register">
    <div class="login_content">
        <h1>用户注册</h1>
        <form action="register_process.php" method="post">
            <div class="form-group">
                <label for="username">用户名</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">邮箱</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">密码</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">确认密码</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="form-group">
                <input type="submit" value="注册">
            </div>
            <div class="form-group">
                <p>已有账号？<a href="login.php">立即登录</a></p>
            </div>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>