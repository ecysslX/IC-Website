<?php include 'sidebar.php'; ?>

<!-- 登录页面 -->
<div class="tabcontent" id="login">
    <div class="login_content">
        <h1>用户登录</h1>
        <form action="login_process.php" method="post">
            <div class="form-group">
                <label for="username">用户名</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">密码</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <input type="submit" value="登录">
            </div>
            <div class="form-group">
                <p>还没有账号？<a href="register.php">立即注册</a></p>
            </div>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>