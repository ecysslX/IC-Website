<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="pic/icon.ico">
    <title>I Wanna Be The Creator 游戏网站</title>
</head>
<body>

    <!-- 顶部导航栏 -->
    <div id="header_link">
        <nav>
            <?php
            // 检查登录状态
            session_start();
            if (isset($_SESSION['username'])) {
                echo '<div class="login_icon" style="color: white; line-height: 50px; margin-right: 20px;">欢迎，' . $_SESSION['username'] . '</div>';
            } else {
                echo '<div class="login_icon"><a href="login.php"><img src="pic/icon.ico" alt="登录" id="login_img"></a></div>';
            }
            ?>
            <div class="tabdiv <?php if(basename($_SERVER['PHP_SELF']) == 'home.php') echo 'active'; ?>">
                <a href="home.php"><h4>首页</h4></a>
            </div>
            <div class="tabdiv <?php if(basename($_SERVER['PHP_SELF']) == 'wiki.php') echo 'active'; ?>">
                <a href="wiki.php"><h4>百科</h4></a>
            </div>
            <div class="tabdiv <?php if(basename($_SERVER['PHP_SELF']) == 'tools.php') echo 'active'; ?>">
                <a href="tools.php"><h4>工具</h4></a>
            </div>
            <div class="tabdiv <?php if(basename($_SERVER['PHP_SELF']) == 'community.php') echo 'active'; ?>">
                <a href="community.php"><h4>社区</h4></a>
            </div>
            <div class="tabdiv <?php if(basename($_SERVER['PHP_SELF']) == 'download.php') echo 'active'; ?>">
                <a href="download.php"><h4>下载</h4></a>
            </div>
            <div class="tabdiv <?php if(basename($_SERVER['PHP_SELF']) == 'profile.php') echo 'active'; ?>">
                <a href="<?php echo isset($_SESSION['username']) ? 'profile.php' : 'login.php'; ?>"><h4>我的</h4></a>
            </div>
        </nav>
    </div>

    <!-- 主体内容 -->
    <div id="main_content">